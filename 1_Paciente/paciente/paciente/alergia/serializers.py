from rest_framework import serializers
from .models import Alergia


class AlergiaSerializer(serializers.ModelSerializer):
    class Meta:
        model = Alergia
        fields = '__all__'
