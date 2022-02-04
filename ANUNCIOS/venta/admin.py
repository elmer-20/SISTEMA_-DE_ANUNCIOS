from django.contrib import admin

# Register your models here.
from venta.models import Venta, DetalleVenta

admin.site.register(Venta)
admin.site.register(DetalleVenta)
