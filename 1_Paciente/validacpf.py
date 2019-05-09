#https://github.com/matheuscas/pycpfcnpj

#Instalação do módulo: pip install pycpfcnpj

from pycpfcnpj import cpfcnpj
cpf_number = '11144477735'
masked_cpf_number = '111.444.777-35'
cnpj_number = '11444777000161'
masked_cnpj_number = '11.444.777/0001-61'

print (cpfcnpj.validate(cpf_number))
print (cpfcnpj.validate(masked_cpf_number))
print (cpfcnpj.validate(cnpj_number))
print (cpfcnpj.validate(masked_cnpj_number))
