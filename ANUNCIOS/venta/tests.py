from datetime import datetime

from django.test import TestCase

# Create your tests here.
from producto.models import Producto, Categoria
from venta.models import Venta, DetalleVenta


class VentaTestCase(TestCase):
    def setUp(self):
        venta = Venta()
        venta.fecha = datetime.now()
        venta.save()
        venta.codigo = 'C0MPR4M3-XXD' + str(venta.id)
        venta.save()

        categoria = Categoria.objects.create(nombre='teléfonos')

        Producto.objects.create(nombre='iPhone 5s', descripción='Teléfono de ricos para pobres',
                                categoria=categoria, en_stock=5.00, precio=1250.00
                                )
        Producto.objects.create(nombre='iPhone X', descripción='Teléfono de ricos para inmortales',
                                categoria=categoria, en_stock=2.00, precio=7500.00
                                )

    def test_venta_validar_total(self):
        producto1 = Producto.objects.get(nombre='iPhone 5s')
        producto2 = Producto.objects.get(nombre='iPhone X')
        venta = Venta.objects.all().first()

        # Creamos 2 detalle producto
        # 1
        detalle_producto1 = DetalleVenta()
        detalle_producto1.producto = producto1
        detalle_producto1.venta = venta
        detalle_producto1.cantidad = 2
        detalle_producto1.precio = producto1.precio
        detalle_producto1.save()

        # 2
        detalle_producto2 = DetalleVenta()
        detalle_producto2.producto = producto2
        detalle_producto2.venta = venta
        detalle_producto2.cantidad = 2
        detalle_producto2.precio = producto2.precio
        detalle_producto2.save()

        # Pagamos la venta
        venta.pagar()
        venta.save()

        total_productos = (detalle_producto1.cantidad * detalle_producto1.precio) + (
                detalle_producto2.cantidad * detalle_producto2.precio)

        self.assertEquals(total_productos, venta.total, 'No se ha guardado bien el total de la venta')
        self.assertEquals(venta.total, venta.get_cart_total,
                          'El método get cart total no ha funcionado de manera correcta')

    def test_venta_est_no_creada_add_prod(self):
        """
        Se tratará de añadir un producto a una venta en estado que no sea creada
        :return:
        """
        venta = Venta.objects.all().last()
        producto = Producto.objects.all().last()
        cantidad = producto.en_stock

        se_agrego1 = self.add_producto(venta, producto, cantidad)
        self.assertTrue(se_agrego1, 'No se agregó el producto, el estado de la venta no es Creada')

        # Se paga la venta: no se podrían agregar más productos a la venta
        venta.pagar()
        venta.save()

        # Se intenta agregar otra vez el producto a la venta con estado pagada
        se_agrego = self.add_producto(venta, producto, cantidad)
        self.assertTrue(se_agrego, 'No se agregó el producto, el estado de la venta no es Creada')

    def add_producto(self, venta, producto, cantidad):
        if venta.estado == venta.ESTADO_CREADA:
            detalle_venta = DetalleVenta()
            detalle_venta.venta = venta
            detalle_venta.producto = producto
            detalle_venta.cantidad = cantidad
            detalle_venta.precio = producto.precio
            detalle_venta.save()

            producto.en_stock = producto.en_stock - cantidad
            producto.save()
            return True

        else:
            return False
