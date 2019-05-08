from rest_framework.views import APIView
from django.shortcuts import render

from rest_framework import status
from rest_framework.response import Response
from rest_framework.viewsets import ModelViewSet
from .models import CarteiraVacina
from .serializers import CarteiraVacinaSerializer
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
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response({
            'errors': serializer.errors,
            'message': 'Preencha todos os campos corretamente!'
        }, status=status.HTTP_400_BAD_REQUEST)

    # GET ALL
    def list(self, request):
        return Response(self.get_serializer_class()(self.queryset.all(), many=True).data, status.HTTP_200_OK)

    # GET POR CPF
    def retrieve(self, request, *args, **kwargs):
        elements = self.queryset.filter(
            vac_cpfpatient=kwargs.get("pk")).first()
        if elements:
            return Response(self.get_serializer_class()(elements).data, status.HTTP_200_OK)
        return Response({"message": "Carteira de vacina não encontrada!"}, status.HTTP_404_NOT_FOUND)

    # # PUT
    # def update(self, request, *args, **kwargs):
    #     element = self.queryset.filter(id=kwargs.get("pk")).first()
    #     if element:
    #         serializer = self.serializer_class(
    #             element, data=request.data, partial=True)
    #         if serializer.is_valid():
    #             serializer.save()
    #             return Response(serializer.data, status=status.HTTP_201_CREATED)
    #         return Response({
    #             'errors': serializer.errors,
    #             'message': 'Preencha todos os campos corretamente!'
    #         }, status=status.HTTP_400_BAD_REQUEST)
    #     return Response({"message": "Alergia não encontrada!"}, status.HTTP_404_NOT_FOUND)
