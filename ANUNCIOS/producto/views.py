from django.http import Http404
from django.shortcuts import render
from django.urls import reverse_lazy
from django.views.generic import ListView, UpdateView, DeleteView, CreateView

from producto.forms import ProductoForm, CategoriaForm
from producto.models import Producto, Categoria

# Producto Views
from venta.models import Venta


class ProductManage(ListView):
    model = Producto
    template_name_suffix = '_manage'


class ProductCreate(CreateView):
    model = Producto
    form_class = ProductoForm
    success_url = reverse_lazy('producto:manage')


class ProductUpdate(UpdateView):
    model = Producto
    form_class = ProductoForm
    template_name_suffix = '_update_form'

    def get_context_data(self, *, object_list=None, **kwargs):
        context = super(ProductUpdate, self).get_context_data(**kwargs)
        producto = Producto.objects.get(id=self.kwargs['pk'])
        if not producto:
            raise Http404
        else:
            # Añadimos al contexto el objeto del producto
            context['nombre'] = producto.nombre
        return context

    def get_success_url(self):
        return reverse_lazy('producto:manage')


class ProductoDelete(DeleteView):
    model = Producto
    success_url = reverse_lazy('producto:manage')


# Categoría Views

class CategoriaList(ListView):
    model = Categoria


class CategoriaCreate(CreateView):
    model = Categoria
    form_class = CategoriaForm
    success_url = reverse_lazy('producto:categoria_index')


class CategoriaUpdate(UpdateView):
    model = Categoria
    form_class = CategoriaForm
    template_name_suffix = '_update_form'

    def get_success_url(self):
        return reverse_lazy('producto:categoria_index')


class CategoriaDelete(DeleteView):
    model = Categoria
    success_url = reverse_lazy('producto:categoria_index')
