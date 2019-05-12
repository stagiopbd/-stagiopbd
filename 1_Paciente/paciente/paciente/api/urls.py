from django.conf.urls import url
from django.template.response import TemplateResponse
from django.urls import path, include
from rest_framework.routers import SimpleRouter

from paciente.views import PacienteViewSet, index_paciente, index
from alergia.views import AlergiaViewSet, PacienteTemAlergiaViewSet, index_alergia
from quadro_clinico.views import QuadroClinicoViewSet, index_quadro_clinico
from carteira_vacina.views import CarteiraVacinaViewSet, MedicamentoViewSet, index_carteira_vacina

router = SimpleRouter(trailing_slash=False)
router.register(r'paciente', PacienteViewSet)
router.register(r'alergia', AlergiaViewSet)
router.register(r'paciente-alergia', PacienteTemAlergiaViewSet)
router.register(r'quadro_clinico', QuadroClinicoViewSet)
router.register(r'carteira_vacina', CarteiraVacinaViewSet)
router.register(r'medicamento', MedicamentoViewSet)

urlpatterns = [
    path('stagiop_bd', index, name='index'),
    path('stagiop_bd/api/', include(router.urls)),
    path('stagiop_bd/paciente', index_paciente, name='index_paciente'),
    path('stagiop_bd/alergia', index_alergia, name='index_alergia'),
    path('stagiop_bd/quadro_clinico', index_quadro_clinico,
         name='index_quadro_clinico'),
    path('stagiop_bd/carteira_vacina',
         index_carteira_vacina, name='index_carteira_vacina'),
]
