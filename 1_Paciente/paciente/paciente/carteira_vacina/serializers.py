from rest_framework import serializers
from .models import CarteiraVacina


class CarteiraVacinaSerializer(serializers.ModelSerializer):
    class Meta:
        model = CarteiraVacina
        fields = '__all__'
