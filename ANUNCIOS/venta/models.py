from django.db import models

# Create your models here.
from django_fsm import FSMField, transition, FSMIntegerField

from producto.models import Producto
from repositories.VentaRepository import VentaRepository


class Venta(models.Model):
    codigo = models.CharField(max_length=200, null=True, blank=True)
    fecha = models.DateTimeField(auto_now_add=True)
    total = models.DecimalField(max_length=4, decimal_places=2, max_digits=10, null=True)
    nombre_factura = models.CharField(max_length=200, null=True, blank=True)
    nit = models.IntegerField(null=True, blank=True)
    razon_cancelacion = models.CharField(max_length=200, null=True, blank=True)

    ESTADO_CREADA = 0
    ESTADO_PAGADA = 1
    ESTADO_FACTURADA = 2
    ESTADO_FINALIZADA = 3
    ESTADO_CANCELADA = 4
    ESTADO_ANULADA = 5

    ESTADOS = (
        (ESTADO_CREADA, 'creada'),
        (ESTADO_PAGADA, 'pagada'),
        (ESTADO_FACTURADA, 'facturada'),
        (ESTADO_FINALIZADA, 'finalizada'),
        (ESTADO_CANCELADA, 'cancelada'),
        (ESTADO_ANULADA, 'anulada'),
    )

    estado = FSMIntegerField(choices=ESTADOS, default=0, protected=True)

    @transition(estado, source=ESTADO_CREADA, target=ESTADO_PAGADA)
    def pagar(self):
        VentaRepository.pagar(self)

    @transition(estado, source=ESTADO_PAGADA, target=ESTADO_FACTURADA)
    def facturar(self, nombre, nit):
        VentaRepository.facturar(self, nombre, nit)

    @transition(estado, source=[ESTADO_PAGADA, ESTADO_FACTURADA], target=ESTADO_FINALIZADA)
    def finalizar(self):
        VentaRepository.finalizar(self)

    @transition(estado, source=ESTADO_CREADA, target=ESTADO_CANCELADA)
    def cancelar(self, motivo):
        VentaRepository.cancelar(self, motivo)

    @transition(estado, source=[ESTADO_PAGADA, ESTADO_FACTURADA, ESTADO_FINALIZADA], target=ESTADO_ANULADA)
    def anular(self, motivo):
        VentaRepository.anular(self, motivo)

    @property
    def get_cart_total(self):
        detalleventas = self.detalleventa_set.all()
        total = sum([item.get_total for item in detalleventas])
        return total

    @property
    def get_cart_items(self):
        detalleventas = self.detalleventa_set.all()
        total = sum([item.cantidad for item in detalleventas])
        return total

    @property
    def get_date(self):
        if self.estado == self.ESTADO_CREADA:
            return 'En curso'
        else:
            return self.fecha

    def __str__(self):
        return self.codigo


class DetalleVenta(models.Model):
    venta = models.ForeignKey(Venta, on_delete=models.CASCADE)
    producto = models.ForeignKey(Producto, on_delete=models.CASCADE)
    cantidad = models.DecimalField(max_length=4, decimal_places=2, max_digits=4)
    precio = models.PositiveIntegerField()

    @property
    def get_total(self):
        return self.cantidad * self.precio

    def __str__(self):
        return self.producto.__str__() + ', cantidad: ' + self.cantidad.__str__() + ' -- ' + self.venta.codigo
