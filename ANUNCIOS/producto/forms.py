from django import forms

from producto.models import Producto, Categoria


class ProductoForm(forms.ModelForm):
    nombre = forms.TextInput(attrs={'class': 'form-control'})
    descripción = forms.TextInput(attrs={'class': 'form-control'})
    precio = forms.DecimalField(initial=00.00, min_value=0,
                                widget=forms.NumberInput(attrs={
                                    'class': 'form-control',
                                }))
    en_stock = forms.DecimalField(initial=00.0, min_value=0,
                                  widget=forms.NumberInput(attrs={
                                      'class': 'form-control',
                                  }))
    categoria = forms.Select(attrs={'class': 'form-control'})

    class Meta:
        model = Producto
        fields = ['nombre', 'descripción', 'precio', 'en_stock', 'categoria']
        widgets = {
            'nombre': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Nombre de la materia'
            }),
            'descripción': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Descripción del producto'
            }),
        }
        labels = {}


class CategoriaForm(forms.ModelForm):
    class Meta:
        model = Categoria
        fields = '__all__'
        widgets = {
            'nombre': forms.TextInput(attrs={
                'class': 'form-control',
                'placeholder': 'Nombre de la categoría'
            }),
        }
