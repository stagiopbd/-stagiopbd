from django.db import models


class Sample(models.Model):
    cpf = models.CharField(max_length=11)
    name = models.CharField(max_length=120)

    def __repr__(self):
        return f'{self.name}'
