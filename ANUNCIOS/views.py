from datetime import datetime

from django.db import transaction
from django.http import HttpResponse
from django.shortcuts import render

from ventas.models.venta import Venta


@transaction.atomic
def crear_venta(request):
	venta = Venta()
	venta.fecha = datetime.now()
	venta.codigo = "1"
	venta.save()
	return HttpResponse(venta)


@transaction.atomic
def pagar_venta(request):
	venta_id = request.data['id']
	venta = Venta.objects.filter(id=venta_id).first()
	venta.pagar(request.data['monto'], request.data['productos'])
	venta.save()
	return HttpResponse(venta)


@transaction.atomic
def facturar_venta(request):
	venta_id = request.data['id']
	venta = Venta.objects.filter(id=venta_id).first()
	venta.facturar(request.data['nombre'], request.data['nit'])
	venta.save()
	return HttpResponse(venta)


@transaction.atomic
def terminar_venta(request):
	venta_id = request.data['id']
	venta = Venta.objects.filter(id=venta_id).first()
	venta.terminar()
	venta.save()
	return HttpResponse(venta)


@transaction.atomic
def cancelar_venta(request):
	venta_id = request.data['id']
	venta = Venta.objects.filter(id=venta_id).first()
	venta.cancelar(request.data['motivo'])
	venta.save()
	return HttpResponse(venta)


@transaction.atomic
def anular_venta(request):
	venta_id = request.data['id']
	venta = Venta.objects.filter(id=venta_id).first()
	venta.anular(request.data['motivo'], request.data['devolucion'])
	venta.save()
	return HttpResponse(venta)
