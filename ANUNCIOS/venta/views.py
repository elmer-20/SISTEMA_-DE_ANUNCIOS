from django.db.models import Sum, Q
from django.http import HttpResponseBadRequest
from django.shortcuts import render, get_object_or_404
from decimal import Decimal

from django.urls import reverse_lazy
from django.views.generic import ListView, UpdateView, DetailView

from producto.models import Producto
from venta.forms import VentaForm, VentaFacturaForm
from venta.models import Venta, DetalleVenta


class VentaList(ListView):
    model = Venta
    queryset = Venta.objects.all().order_by('-fecha')

    def get_context_data(self, *, object_list=None, **kwargs):
        context = super(VentaList, self).get_context_data(**kwargs)
        # Todo: Sumar todo lo vendido y la cantidad de ventas
        # total_vendido = DetalleVenta.objects.filter(venta__estado=Venta.ESTADO_FINALIZADA).aggregate(Sum('total'))
        # context['total_vendido'] = total_vendido
        return context


class VentaDetail(DetailView):
    model = Venta


class VentaFactura(UpdateView):
    """
    Facturación de la venta, la venta no puede ser facturada si no se encuentra en estado pagada
    """
    model = Venta
    form_class = VentaFacturaForm
    template_name_suffix = '_facturar_form'
    success_url = reverse_lazy('venta:carrito')

    def dispatch(self, request, *args, **kwargs):
        # La venta no puede entrar a esta vista si se encuentra en estado pagada
        venta = Venta.objects.get(id=self.kwargs['pk'])
        if not venta.estado == venta.ESTADO_PAGADA:
            return HttpResponseBadRequest()

        return super(VentaFactura, self).dispatch(request, *args, **kwargs)

    def form_valid(self, form):
        venta = get_object_or_404(Venta, id=self.kwargs['pk'])
        redirect_url = super(VentaFactura, self).form_valid(form)
        nit = form.cleaned_data['nit']
        nombre = form.cleaned_data['nombre_factura']

        venta.facturar(nombre, nit)
        venta.save()
        return redirect_url


class VentaUpdate(UpdateView):
    """
    Actualización de la venta (cambiar de estado a anulada o cancelada), ningún otro cambio puede ser actualizado
    """
    model = Venta
    form_class = VentaForm
    template_name_suffix = '_update_form'
    success_url = reverse_lazy('venta:ventas')

    def dispatch(self, request, *args, **kwargs):
        # La venta no puede entrar a esta vista si se encuentra en estado cancelada o anulada
        venta = Venta.objects.get(id=self.kwargs['pk'])
        if venta.estado == venta.ESTADO_ANULADA or venta.estado == venta.ESTADO_CANCELADA:
            return HttpResponseBadRequest()

        return super(VentaUpdate, self).dispatch(request, *args, **kwargs)

    def get_context_data(self, *, object_list=None, **kwargs):
        context = super(VentaUpdate, self).get_context_data(**kwargs)
        venta = get_object_or_404(Venta, id=self.kwargs['pk'])
        context['venta'] = venta
        return context

    def form_valid(self, form):
        venta = get_object_or_404(Venta, id=self.kwargs['pk'])
        redirect_url = super(VentaUpdate, self).form_valid(form)
        motivo = form.cleaned_data['razon_cancelacion']

        if venta.estado == venta.ESTADO_CREADA:
            venta.cancelar(motivo)
            obtener_venta_actual()
        else:
            venta.anular(motivo)

        devolver_productos_a_stock(venta.id)
        venta.save()
        return redirect_url


def product_list(request):
    """
    Vista de lista de productos, en esta vista se encuentra también la lógica de añadir producto al carrito
    :param request:
    :return:
    """
    venta = obtener_venta_actual()
    data = {}
    lista_productos = Producto.objects.order_by('nombre')

    if request.method == 'POST':
        if 'btnsearch' in request.POST:
            search = request.POST['search']
            if not search == '':
                lista_productos = Producto.objects.filter(
                    Q(nombre__contains=search) | Q(categoria__nombre__contains=search)).distinct()
            else:
                lista_productos = Producto.objects.order_by('nombre')
            if not lista_productos:
                data['status'] = 'Sin resultados'
        else:
            producto = get_object_or_404(Producto, id=request.POST['id_producto'])
            cantidad = Decimal(request.POST['cantidad'])

            data['status'] = agregar_producto_a_carrito(venta, cantidad, producto)

    context = {'producto_list': lista_productos, 'data': data, 'venta': venta}

    return render(request, 'venta/producto_list.html', context)


def carrito(request):
    """
    Vista de carrito, en esta vista se muestran los productos añadidos a la venta actual además de podes cambiar de estado
    a la venta y remover productos del 'carrito'

    :param request:
    :return:
    """

    venta = obtener_venta_actual()
    lista_detalle = DetalleVenta.objects.filter(venta=venta)
    data = {}
    # Si es post es para eliminar el detalle de la venta
    if request.method == 'POST':
        if 'pagar' in request.POST:
            venta.pagar()
            venta.save()

        elif 'facturar' in request.POST:
            pass

        elif 'finalizar' in request.POST:
            venta.finalizar()
            venta.save()
            new_venta = obtener_venta_actual()
            lista_detalle = DetalleVenta.objects.filter(venta=new_venta)
            return render(request, 'venta/carrito.html',
                          {'lista_detalle': lista_detalle, 'venta': new_venta, 'data': data})

        elif request.POST['detalle_id']:
            nombre_producto_eliminado = eliminar_de_carrito(request.POST['detalle_id'])
            data['eliminado'] = 'Se ha eliminado del carrito: ' + nombre_producto_eliminado + ' de manera exitosa'

    return render(request, 'venta/carrito.html',
                  {'lista_detalle': lista_detalle, 'venta': venta, 'data': data})


def agregar_producto_a_carrito(venta, cantidad, producto):
    """
    En este método se encuentra la lógica de crear un detalle producto por
    el producto que se ha seleccionado para agregar

    :param venta:
    :param cantidad:
    :param producto:
    :return:
    """
    if venta.estado == venta.ESTADO_CREADA:
        detalle_venta = DetalleVenta()
        detalle_venta.venta = venta
        detalle_venta.producto = producto
        detalle_venta.cantidad = cantidad
        detalle_venta.precio = producto.precio
        detalle_venta.save()

        producto.en_stock = producto.en_stock - cantidad
        producto.save()

        return producto.nombre.capitalize() + ' se ha agregado al carrito de manera exitosa.'
    else:
        return 'False'


def eliminar_de_carrito(detalle_id):
    """
    En este método se encuentra la lógica de eliminar el DetalleProducto del 'Carrito'

    :param detalle_id:
    :return:
    """
    detalle_venta = DetalleVenta.objects.get(id=detalle_id)
    producto = detalle_venta.producto
    producto.en_stock = producto.en_stock + detalle_venta.cantidad
    producto.save()
    detalle_venta.delete()
    return detalle_venta.producto.nombre


def vaciar_carrito(venta_id):
    """
    Método para vaciar por completo 'el carrito' de la venta actual, este método elimina todos los detalleventa que existan
    con la venta actual y devolverá a stock de cada producto los productos retirados de la venta

    Uso actual: Sin uso

    :param venta_id:
    :return:
    """
    venta = get_object_or_404(Venta, venta_id)
    for detalleventa in venta.detalleventa_set.all():
        eliminar_de_carrito(detalleventa.id)


def obtener_venta_actual():
    """
    Método que retorna la venta actual, se pueden seguir realizando acciones en la venta hasta que la venta se encuentre
    en estado cancelada, finalizada o anulada
    :return Venta:
    """
    venta = Venta.objects.filter(estado=Venta.ESTADO_FACTURADA).first()
    if not venta:
        venta = Venta.objects.filter(estado=Venta.ESTADO_PAGADA).first()
    if not venta:
        # Si no existe una venta en estado creado, la creamos
        venta, create = Venta.objects.get_or_create(estado=Venta.ESTADO_CREADA)
        venta.save()

    if not venta.codigo:
        venta.codigo = 'C0MPR4M3-XXD' + str(venta.id)
        venta.save()

    return venta


def devolver_productos_a_stock(id_venta):
    # Obtenemos la venta que ha sido anulada/cancelada
    venta = get_object_or_404(Venta, id=id_venta)

    # Obtenemos los detalle venta en esa venta y los iteramos
    for detalleventa in venta.detalleventa_set.all():
        # Aumentamos el stock de los productos que estaban en la venta que ha sido cancelada/anulada
        detalleventa.producto.en_stock = detalleventa.producto.en_stock + detalleventa.cantidad
        detalleventa.producto.save()
