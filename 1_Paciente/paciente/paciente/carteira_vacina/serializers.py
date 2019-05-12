from rest_framework import serializers
from .models import CarteiraVacina, Medicamento


class CarteiraVacinaSerializer(serializers.ModelSerializer):
    class Meta:
        model = CarteiraVacina
        fields = '__all__'


class MedicamentoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Medicamento
        fields = '__all__'
