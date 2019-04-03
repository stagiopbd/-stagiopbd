from rest_framework import serializers
from .models import Paciente, QuadroClinico


class PacienteSerializer(serializers.ModelSerializer):
    class Meta:
        model = Paciente
        fields = '__all__'


class QuadroClinicoSerializer(serializers.ModelSerializer):
    class Meta:
        model = QuadroClinico
        fields = '__all__'