from django import forms

from venta.models import Venta


class VentaForm(forms.ModelForm):
    class Meta:
        model = Venta
        fields = {'razon_cancelacion', }
        widgets = {
            'razon_cancelacion': forms.TextInput(attrs={
                'class': 'form-control',
                'required': 'true',
                'placeholder': 'Escriba una razón detallada'
            })
        }
        labels = {
            'razon_cancelacion': 'Razón'
        }


class VentaFacturaForm(forms.ModelForm):
    class Meta:
        model = Venta
        fields = {'nit', 'nombre_factura'}
        widgets = {
            'nit': forms.TextInput(attrs={
                'class': 'form-control',
                'required': 'true',
                'placeholder': 'Número de nit'
            }),
            'nombre_factura': forms.TextInput(attrs={
                'class': 'form-control',
                'required': 'true',
                'placeholder': 'Nombre para la factura'
            })
        }
        labels = {
            'nit': 'NIT',
            'nombre_factura': 'Nombre de factura'
        }
