from rest_framework.views import APIView
from django.shortcuts import render

from rest_framework import status
from rest_framework.response import Response
from rest_framework.viewsets import ModelViewSet
from .models import Paciente, QuadroClinico
from .serializers import PacienteSerializer, QuadroClinicoSerializer
from django.shortcuts import get_object_or_404
from rest_framework.renderers import TemplateHTMLRenderer
from copy import deepcopy


def index(request):
    return render(request, 'index.html')


class PacienteViewSet(ModelViewSet):
    queryset = Paciente.objects
    serializer_class = PacienteSerializer

    def get_object(self):
        return get_object_or_404(Paciente, cpf=self.kwargs.get("pk"))


class QuadroClinicoViewSet(ModelViewSet):
    queryset = QuadroClinico.objects
    serializer_class = QuadroClinicoSerializer

    def get_object(self):
        return get_object_or_404(QuadroClinico, paciente_id=self.kwargs.get("pk"))

    def create(self, request, *args, **kwargs):
        data = deepcopy(request.data)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    def list(self, request):
        return Response(self.get_serializer_class()(self.queryset.all(), many=True).data, status.HTTP_200_OK)

    def retrieve(self, request, *args, **kwargs):
        elements = self.queryset.filter(paciente_id=kwargs.get("pk")).all()
        if elements:
            return Response(self.get_serializer_class()(elements, many=True).data, status.HTTP_200_OK)
        return Response({"message": "Not Found"}, status.HTTP_404_NOT_FOUND)

    def update(self, request, *args, **kwargs):
        element = self.queryset.filter(paciente_id=kwargs.get("pk")).first()
        if element:
            serializer = self.serializer_class(
                element, data=request.data, partial=True)
            if serializer.is_valid():
                serializer.save()
                return Response(serializer.data, status=status.HTTP_201_CREATED)
            return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
        return Response({"message": "Not Found"}, status.HTTP_404_NOT_FOUND)
