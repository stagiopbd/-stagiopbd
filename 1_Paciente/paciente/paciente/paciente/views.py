from rest_framework.views import APIView
from django.shortcuts import render

from rest_framework import status
from rest_framework.response import Response
from rest_framework.viewsets import ModelViewSet
from .models import Paciente
from .serializers import PacienteSerializer
from django.shortcuts import get_object_or_404
from rest_framework.renderers import TemplateHTMLRenderer
from copy import deepcopy
import numpy as np


def index(request):
    return render(request, 'index.html')


def index_paciente(request):
    return render(request, 'paciente.index.html')


class PacienteViewSet(ModelViewSet):
    queryset = Paciente.objects
    serializer_class = PacienteSerializer

    def get_object(self):
        return get_object_or_404(Paciente, cpf=self.kwargs.get("pk"))
