from rest_framework.views import APIView
from django.shortcuts import render

from rest_framework import status
from rest_framework.response import Response
from rest_framework.viewsets import ModelViewSet
from .models import CarteiraVacina, Medicamento
from .serializers import CarteiraVacinaSerializer, MedicamentoSerializer
from .util import formatar_vacina, formatar_vacina_dict
from django.shortcuts import get_object_or_404
from rest_framework.renderers import TemplateHTMLRenderer
from copy import deepcopy
import numpy as np
import os


def index_carteira_vacina(request):
    url = os.getenv('URL', 'http://127.0.0.1:8000')
    return render(request, 'carteira_vacina.index.html', {'url': url})


class CarteiraVacinaViewSet(ModelViewSet):
    queryset = CarteiraVacina.objects
    serializer_class = CarteiraVacinaSerializer

    def get_object(self):
        return get_object_or_404(CarteiraVacina, id=self.kwargs.get("pk"))

    # POST
    def create(self, request, *args, **kwargs):
        data = deepcopy(request.data)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid():
            element = self.queryset.\
                filter(vac_cpfpatient=serializer.validated_data['vac_cpfpatient']).\
                filter(vac_dose=serializer.validated_data['vac_dose']).\
                filter(vac_medicine=serializer.validated_data['vac_medicine']).\
                select_related().first()
            if element:
                return Response({
                    'errors': "Dose já cadastrada para a vacina {}".format(element.vac_medicine.med_product_description),
                    'message': 'Preencha todos os campos corretamente!'
                }, status=status.HTTP_400_BAD_REQUEST)
            serializer.save()
            element = self.queryset.\
                filter(vac_idvaccine=serializer.data['vac_idvaccine']).\
                select_related().first()
            return Response(formatar_vacina(element), status=status.HTTP_201_CREATED)
        return Response({
            'errors': serializer.errors,
            'message': 'Preencha todos os campos corretamente!'
        }, status=status.HTTP_400_BAD_REQUEST)

    # GET ALL
    def list(self, request):
        data = self.queryset.select_related().all()
        result = []
        if data:
            for item in data:
                result.append(formatar_vacina(item))
        return Response(result, status.HTTP_200_OK)

    # GET POR CPF
    def retrieve(self, request, *args, **kwargs):
        elements = self.queryset.filter(
            vac_cpfpatient=kwargs.get("pk")).select_related().all()
        if elements:
            result = []
            for item in elements:
                result.append(formatar_vacina(item))
            return Response(result, status.HTTP_200_OK)
        return Response({"message": "Carteira de vacina não encontrada!"}, status.HTTP_404_NOT_FOUND)


class MedicamentoViewSet(ModelViewSet):
    queryset = Medicamento.objects
    serializer_class = MedicamentoSerializer

    # GET ALL
    def list(self, request, *args, **kwargs):
        principle = request.query_params.get('principle', 'vacina').upper()
        medicines = self.queryset.\
            filter(med_active_principle__contains=principle).\
            order_by('med_active_principle').all()
        return Response(self.get_serializer_class()(medicines, many=True).data, status.HTTP_200_OK)
