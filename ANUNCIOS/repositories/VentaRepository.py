from datetime import datetime


class VentaRepository:
    @staticmethod
    def pagar(venta):
        venta.fecha = datetime.now()
        venta.total = venta.get_cart_total

    @staticmethod
    def facturar(venta, nombre, nit):
        venta.nombre_factura = nombre
        venta.nit = nit

    @staticmethod
    def cancelar(venta, motivo):
        venta.razon_cancelacion = motivo

    @staticmethod
    def anular(venta, motivo):
        venta.razon_cancelacion = motivo

    @staticmethod
    def finalizar(venta):
        pass


