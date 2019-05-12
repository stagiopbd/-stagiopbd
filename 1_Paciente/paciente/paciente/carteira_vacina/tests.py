from django.test import TestCase
from .models import CarteiraVacina, Medicamento
from paciente.models import Paciente
from django.utils import timezone
from random import randint, random, uniform
from rest_framework.test import APIRequestFactory
from .views import MedicamentoViewSet
from django.urls import reverse
from rest_framework.test import APIClient
from .serializers import CarteiraVacinaSerializer


class CarteiraVacinaTest(TestCase):
    def setUp(self):
        vacinas = []
        for i in range(3):
            a = Medicamento.objects.create(**{
                'med_id': i+1,
                "med_active_principle": "VACINA {}".format("A" * (i+1)),
                "med_code_ggrem": "545318080002907",
                "med_register": "1223400140028",
                "med_ean1": "7897965400081",
                "med_ean2": "",
                "med_ean3": "",
                "med_product_description": "VACINA {}".format("A" * (i+1)),
                "med_presentation": "SUSP INJ CT 50 AMP VD INC X 0,5 ML",
                "med_hospital_restrictions": True,
                "med_cap": True,
                "med_confaz87": True,
                "med_marketing_year": 0,
                "med_sup_id": 218,
                "med_thc_id": 289,
                "med_pdt_id": 2,
                "med_stp_id": 2
            })
            vacinas.append(a)

        cpfs = ['81653635061', '11928717071']
        for i in range(len(cpfs)):
            p = Paciente.objects.create(**{
                "cpf": cpfs[i],
                "nome_completo": "teste teste",
                "data_nascimento": "1980-01-01",
                "sexo": "m",
                "tipo_sanguineo": "A+"
            })
            CarteiraVacina.objects.create(**{
                "vac_date": "2019-05-10",
                "vac_next": "2020-05-11",
                "vac_batch": "1",
                "vac_dose": 2,
                "vac_responsible": "qqq",
                "vac_medicine": vacinas[i+1],
                "vac_cpfpatient": p
            })
        p = Paciente.objects.create(**{
            "cpf": '52495749046',
            "nome_completo": "teste teste",
            "data_nascimento": "1980-01-01",
            "sexo": "m",
            "tipo_sanguineo": "A+"
        })
        self.client = APIClient()

    def testePost(self):
        qc = {
            "vac_date": "2019-05-10",
            "vac_next": "2020-05-11",
            "vac_batch": "1",
            "vac_dose": 2,
            "vac_responsible": "qqq",
            "vac_medicine": 1,
            "vac_cpfpatient": "52495749046"
        }
        response = self.client.post(
            '/stagiop_bd/api/carteira_vacina', qc, format='json')
        self.assertEqual(response.status_code, 201)
        self.assertEqual(response.data['vac_cpfpatient'], qc['vac_cpfpatient'])

    def testeList(self):
        response = self.client.get('/stagiop_bd/api/carteira_vacina')
        data = CarteiraVacina.objects.all()
        self.assertEqual(len(response.data), len(data))
        self.assertEqual(response.status_code, 200)

    def testeGet(self):
        response = self.client.get(
            '/stagiop_bd/api/carteira_vacina/81653635061')
        data = CarteiraVacina.objects.filter(
            vac_cpfpatient="81653635061").all()
        self.assertEqual(len(response.data), len(data))
        self.assertEqual(response.status_code, 200)

    def testeGet404(self):
        response = self.client.get('/stagiop_bd/api/carteira_vacina/98498194')
        self.assertEqual(response.status_code, 404)
