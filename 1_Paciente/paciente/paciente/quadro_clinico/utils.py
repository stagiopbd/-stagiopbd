import numpy as np


def calc_imc(peso, altura):
    imc = np.divide(peso, np.power(altura, 2))

    if imc < 16:
        imc_classe = "Magreza grau III"
    elif imc < 17:
        imc_classe = "Magreza grau II"
    elif imc < 18.5:
        imc_classe = "Magreza grau II"
    elif imc < 25:
        imc_classe = "Saudável"
    elif imc < 30:
        imc_classe = "Sobrepeso"
    elif imc < 35:
        imc_classe = "Obesidade Grau I"
    elif imc < 40:
        imc_classe = "Obesidade Grau II (severa)"
    else:
        imc_classe = "Obesidade Grau III (mórbida)"
    return imc_classe
