from django.contrib import admin

from anuncios.models import *

admin.site.register(Categoria)
admin.site.register(Anuncio)
admin.site.register(Ubicacion)
admin.site.register(Usuario)