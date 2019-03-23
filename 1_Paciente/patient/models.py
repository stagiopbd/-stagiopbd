from django.db import models

# Create your models here.
class Patient(models.Model):
    id = models.IntegerField(primary_key=True)
    nome = models.CharField(max_length=200)
    sexo = models.CharField(max_length=1)
    tipoSanguineo = models.CharField(max_length=3)
    dataNasc = models.DateTimeField()
    