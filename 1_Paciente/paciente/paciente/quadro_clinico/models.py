from django.db import models
from paciente.models import Paciente


class QuadroClinico(models.Model):
    paciente = models.OneToOneField(Paciente, on_delete=models.CASCADE)
    peso = models.FloatField()
    altura = models.FloatField()
    imc = models.CharField(max_length=120, blank=True, null=True)
    fuma = models.BooleanField()
    fuma_frequencia = models.CharField(max_length=120, blank=True, null=True)
    bebe = models.BooleanField()
    bebe_frequencia = models.CharField(max_length=120, blank=True, null=True)
    pratica_atividade = models.BooleanField()
    pratica_frequencia = models.CharField(
        max_length=120, blank=True, null=True)

    class Meta:
        db_table = "quadro_clinico"
