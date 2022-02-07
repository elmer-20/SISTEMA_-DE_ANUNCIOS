from django.contrib import admin
from .models import (
    Product, 
    Order, 
    OrderItem, 
    ColourVariation,
    SizeVariation,
    Address,
    Payment,
    Category
)

class AddressAdmin(admin.ModelAdmin):
    list_display = [
        'address_line_1',
        'address_line_1',
        'address_line_2',
        'zip_code',
        'city',
        'address_type',
    ]

admin.site.register(Product)
admin.site.register(Address, AddressAdmin)
admin.site.register(Order)
admin.site.register(OrderItem)
admin.site.register(ColourVariation)
admin.site.register(SizeVariation)
admin.site.register(Payment)
admin.site.register(Category)