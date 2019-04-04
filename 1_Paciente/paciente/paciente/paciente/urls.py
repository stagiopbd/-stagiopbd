from django.conf.urls import url
from django.template.response import TemplateResponse
from django.urls import path, include
from drf_yasg import openapi
from drf_yasg.views import get_schema_view
from rest_framework.routers import SimpleRouter

from api.views import PacienteViewSet, QuadroClinicoViewSet
from api.views import index_quadro_clinico

router = SimpleRouter(trailing_slash=False)
router.register(r'paciente', PacienteViewSet)
router.register(r'quadro-clinico', QuadroClinicoViewSet)

schema_view = get_schema_view(
    openapi.Info(
        title="Paciente API",
        default_version='v1',
        description="Paciente",
        contact=openapi.Contact(email="gustavo.gomides7@gmail.com"),
        license=openapi.License(name="BSD License"),
    ),
    validators=['flex', 'ssv'],
    public=True,
)

urlpatterns = [
    url(r'^swagger(?P<format>\.json|\.yaml)$',
        schema_view.without_ui(cache_timeout=0), name='schema-json'),
    url(r'^swagger/$', schema_view.with_ui('swagger',
                                           cache_timeout=0), name='schema-swagger-ui'),
    path('api/', include(router.urls)),
    path('quadro-clinico', index_quadro_clinico, name='index_quadro_clinico'),
]
