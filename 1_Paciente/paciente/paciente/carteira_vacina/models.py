from django.db import models
from paciente.models import Paciente


class CarteiraVacina(models.Model):
    vac_idvaccine = models.AutoField(primary_key=True)
    vac_name = models.CharField(max_length=30)
    vac_date = models.DateField()
    vac_next = models.DateField()
    vac_batch = models.CharField(max_length=10)
    vac_dose = models.IntegerField()
    vac_responsible = models.CharField(max_length=30)
    vac_cpfpatient = models.OneToOneField(Paciente, on_delete=models.CASCADE)

    class Meta:
        db_table = "vaccinationcard"
