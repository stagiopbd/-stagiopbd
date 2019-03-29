from rest_framework.views import APIView
from django.shortcuts import render

from rest_framework import status
from rest_framework.response import Response
from rest_framework.viewsets import ModelViewSet
from .models import Sample
from .serializers import SampleSerializer
from django.shortcuts import get_object_or_404
from rest_framework.renderers import TemplateHTMLRenderer
from copy import deepcopy


def index(request):
    return render(request, 'index.html')


class SampleViewSet(ModelViewSet):
    queryset = Sample.objects
    serializer_class = SampleSerializer

    def get_object(self):
        return get_object_or_404(Sample, cpf=self.kwargs.get("pk"))

    """
    Criar um registro
    """

    def create(self, request, *args, **kwargs):
        data = deepcopy(request.data)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    """
    Recuperar todos registros
    """

    def list(self, request):
        return Response(self.get_serializer_class()(self.queryset.all(), many=True).data, status.HTTP_200_OK)

    """
    Recuperar um registro de determinado cpf
    """

    def retrieve(self, request, *args, **kwargs):
        elements = self.queryset.filter(cpf=kwargs.get("pk")).all()
        if elements:
            return Response(self.get_serializer_class()(elements, many=True).data, status.HTTP_200_OK)
        return Response({"message": "Not Found"}, status.HTTP_404_NOT_FOUND)

    """
    Deletar um registro de determinado cpf
    """

    def delete(self, request, *args, **kwargs):
        element = self.get_object()
        element.delete()
