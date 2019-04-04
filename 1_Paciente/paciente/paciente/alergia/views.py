from rest_framework.views import APIView
from django.shortcuts import render

from rest_framework import status
from rest_framework.response import Response
from rest_framework.viewsets import ModelViewSet
from .models import Alergia
from .serializers import AlergiaSerializer
from django.shortcuts import get_object_or_404
from rest_framework.renderers import TemplateHTMLRenderer
from copy import deepcopy
import numpy as np


def index_alergia(request):
    return render(request, 'alergia.index.html')


class AlergiaViewSet(ModelViewSet):
    queryset = Alergia.objects
    serializer_class = AlergiaSerializer

    def get_object(self):
        return get_object_or_404(Alergia, cpf=self.kwargs.get("pk"))
