from django.db import models


# Create your models here.
class Categoria(models.Model):
    nombre = models.CharField(max_length=100)

    def __str__(self):
        return self.nombre


class Producto(models.Model):
    nombre = models.CharField(max_length=100)
    descripción = models.CharField(max_length=200)
    precio = models.DecimalField(max_length=10, decimal_places=2, max_digits=10)
    en_stock = models.DecimalField(max_length=4, decimal_places=2, max_digits=4)

    categoria = models.ForeignKey(Categoria, on_delete=models.SET_NULL, null=True, blank=True)

    def __str__(self):
        return self.nombre + ', precio: ' + self.precio.__str__()
