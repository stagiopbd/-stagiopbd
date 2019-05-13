from django.db import models
from paciente.models import Paciente


class Medicamento(models.Model):
    med_id = models.AutoField(primary_key=True)
    med_active_principle = models.CharField(max_length=2000)
    med_code_ggrem = models.CharField(max_length=15)
    med_register = models.CharField(max_length=13)
    med_ean1 = models.CharField(max_length=14)
    med_ean2 = models.CharField(max_length=14)
    med_ean3 = models.CharField(max_length=14)
    med_product_description = models.CharField(max_length=120)
    med_presentation = models.CharField(max_length=200)
    med_hospital_restrictions = models.BooleanField()
    med_cap = models.BooleanField()
    med_confaz87 = models.BooleanField()
    med_marketing_year = models.IntegerField()
    med_sup_id = models.IntegerField()
    med_thc_id = models.IntegerField()
    med_pdt_id = models.IntegerField()
    med_stp_id = models.IntegerField()

    class Meta:
        db_table = "medicine"


class CarteiraVacina(models.Model):
    vac_idvaccine = models.AutoField(primary_key=True)
    vac_date = models.DateField()
    vac_next = models.DateField()
    vac_batch = models.CharField(max_length=10)
    vac_dose = models.IntegerField()
    vac_responsible = models.CharField(max_length=30)
    vac_medicine = models.ForeignKey(Medicamento, on_delete=models.CASCADE)
    vac_cpfpatient = models.ForeignKey(Paciente, on_delete=models.CASCADE)

    class Meta:
        db_table = "vaccination"
