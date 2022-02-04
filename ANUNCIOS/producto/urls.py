from django.urls import path
from . import views

producto_patterns = ([
                         path('producto/gestionar', views.ProductManage.as_view(), name='manage'),
                         path('producto/create/', views.ProductCreate.as_view(), name='create'),
                         path('producto/update/<int:pk>/', views.ProductUpdate.as_view(), name='update'),
                         path('producto/delete/<int:pk>/', views.ProductoDelete.as_view(), name='delete'),
                         path('categoria/gestionar', views.CategoriaList.as_view(), name='categoria_index'),
                         path('categoria/create/', views.CategoriaCreate.as_view(), name='categoria_create'),
                         path('categoria/update/<int:pk>/', views.CategoriaUpdate.as_view(), name='categoria_update'),
                         path('categoria/delete/<int:pk>/', views.CategoriaDelete.as_view(), name='categoria_delete'),
                     ], 'producto')
