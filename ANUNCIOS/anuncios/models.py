from django.db import models


class Categoria(models.Model):
    titulo = models.CharField(max_length=40)

    def __str__(self):
        return self.titulo

    class Meta:
        ordering = ['titulo']


class Anuncio(models.Model):
    titulo = models.CharField(max_length=40)
    descripcion = models.TextField(null=True, blank=True)
    categoria = models.ForeignKey(Categoria, on_delete=models.CASCADE)
    imagen = models.ImageField('Imagenes', upload_to='imagen/', max_length=255, null=True, blank = True)
    fecha_creacion = models.DateTimeField(auto_now_add=True)
    midificado = models.DateTimeField(auto_now=True)

    def __str__(self):
        return self.titulo

    class Meta:
        ordering = ['-id']


class Ubicacion(models.Model):
    """Model definition for Reserva."""

    # TODO: Define fields here
    id = models.AutoField(primary_key = True)
    pais =  models.CharField(max_length = 255, unique = True)
    cuidad = models.CharField(max_length = 255, unique = True)
    direccion =  models.CharField(max_length = 255, unique = True)   
    fecha_creacion = models.DateField('Fecha de creación', auto_now = False, auto_now_add = True)
    estado = models.BooleanField(default = True, verbose_name = 'Estado')

    class Meta:
        """Meta definition for ubicacion."""

        verbose_name = 'Ubicacion'
        verbose_name_plural = 'ubucaciones'

class Usuario(models.Model):
    nombre = models.CharField(max_length = 255, unique = True)
    apelliidos = models.CharField('Nombres', max_length = 255, blank = True, null = True)
    email = models.EmailField('Correo Electrónico',max_length = 255, unique = True,)
    last_name = models.CharField('Apellidos', max_length = 255, blank = True, null = True)
    imagen = models.ImageField('Imagen de perfil', upload_to='perfil/', max_length=255, null=True, blank = True)
    is_active = models.BooleanField(default = True)
    is_staff = models.BooleanField(default = False)
   
    class Meta:
        verbose_name = 'Usuario'
        verbose_name_plural = 'Usuarios'
    
