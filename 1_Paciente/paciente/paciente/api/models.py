from django.db import models


class Paciente(models.Model):
    cpf = models.CharField(
        primary_key=True, max_length=11)
    nome_completo = models.CharField(max_length=120)
    data_nascimento = models.DateField()
    sexo = models.CharField(max_length=1)
    tipo_sanguineo = models.CharField(max_length=120)

    class Meta:
        db_table = "paciente"


class Alergia(models.Model):
    principio_ativo = models.CharField(max_length=120)
    descricao = models.CharField(max_length=120)
    grau_risco = models.IntegerField()

    class Meta:
        db_table = "alergia"


class PacienteTemAlergia(models.Model):
    paciente = models.ForeignKey(Paciente, on_delete=models.CASCADE)
    alergia = models.ForeignKey(Alergia, on_delete=models.CASCADE)
    consulta_id = models.IntegerField()

    class Meta:
        db_table = "paciente_tem_alergia"


class QuadroClinico(models.Model):
    paciente = models.OneToOneField(Paciente, on_delete=models.CASCADE)
    peso = models.FloatField()
    altura = models.FloatField()
    imc = models.CharField(max_length=120)
    fuma = models.BooleanField()
    fuma_frequencia = models.CharField(max_length=120, blank=True, null=True)
    bebe = models.BooleanField()
    bebe_frequencia = models.CharField(max_length=120, blank=True, null=True)
    pratica_atividade = models.BooleanField()
    pratica_frequencia = models.CharField(max_length=120, blank=True, null=True)

    class Meta:
        db_table = "quadro_clinico"


# Table paciente {
#     pac_cpf varchar[primary key]
#     pac_nomeCompleto varchar[not null]
#     pac_dataNascimento date[not null]
#     pac_sexo char[not null]
#     pac_tipo_sanguineo varchar[not null]
# }

# Table alergia {
#     ale_id int[primary key]
#     ale_principioAtivo varchar[not null]
#     ale_descricao varchar[not null]
#     ale_grauRisco int[not null]
# }

# Table paciente_tem_alergia {
#     pta_paciente_cpf varchar[primary key]
#     pta_alergia_id int[primary key]
#     pta_consulta_id int
# }

# Table quadroClinico {
#     qcl_paciente_cpf varchar[primary key]
#     qcl_peso float
#     qcl_altura float
#     qcl_imc varchar
#     qcl_fuma boolean
#     qcl_fumaFrequencia varchar
#     qcl_bebe boolean
#     qcl_bebeFrequencia varchar
#     qcl_praticaAtividade boolean
#     qcl_praticaFrequencia varchar
# }

# Ref: paciente.pac_cpf > paciente_tem_alergia.pta_paciente_cpf
# Ref: alergia.ale_id > paciente_tem_alergia.pta_alergia_id
# Ref: paciente.pac_cpf > quadroClinico.qcl_paciente_cpf
