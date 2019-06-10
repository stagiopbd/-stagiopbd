# STAGIOP-BD (Módulo FORNECEDOR)

Este é o repositório de código-fonte do módulo de Fornecedores do projeto STAGIOP-BD.
A solução implementada é baseada na linguagem PHP e suportada pelo framework de desenvolvimento Laravel. Mais informações sobre esse framework em: https://laravel.com/

## Integrantes do Time: 

####  Scrum Master:

* HENRIQUE Duarte Borges Louro (CE-245)
* KAUÊ Gustavo Zanetti (CE-245)

####  Development Team:

* THIAGO Henrique Cardoso (CE-240)
* MARCILENNE Campos Cardoso (CE-240)
* Henrique EDUARDO de Macedo (CE-229)
* ROBERTO CARLOS do Nascimento Siqueira (CE-229) 
* ANDRÉ Francisco Morielo Caetano (CE-229)

### INSTALAÇÃO (LINUX/DOCKER)

No momento o produto criado está disponível online na Google Cloud em http://35.237.186.164:8084
A seguir detalhamos o processo de instalação, que é bastante simples.

#### Passo 1: Transferir o código-fonte para o servidor em Nuvem

O ideal é transferir todo esse diretório, mas principalmente a pasta "www" que é a que contém a aplicação principal.
Supondo que exista um diretório no servidor em "/home/usuario/", uma sugestão é criar uma pasta "/home/usuario/sistema" e deixar o código-fonte dentro desse diretório. Porém pode ser colocado em qualquer lugar.

#### Passo 2: Criar os containers com o comando do Docker
A aplicação só depende dos containers de servidor web (NGINX) e aplicação (PHP/Laravel).
Esses e outros containers estão definidos no arquivo docker-compose.yml e podem ser instalados com o comando abaixo.
```
docker-compose up -d
```
#### Passo 3: A aplicação está online!
Nesse momento a aplicação já deverá estar online. Se não estiver, é possível que você precise alterar configurações de porta de acesso ou outras. Recomendamos checar os detalhes nos seguintes arquivos para mais detalhes (dentro da pasta "www"):

* docker-compose.yml
* Dockerfile
* .env
* config/database.php
* config/cypher.php
* nginx/conf.d/app.conf

![Página principal](https://docs.google.com/uc?id=1gYAEUoM1NlzGgTEYPMnxDpE0GVupN_1d)
![Cadastro de fornecedor](https://docs.google.com/uc?id=193TEJOeIzXoxcds2a7x0R4u4R7r6A6k5)
![Listagem de fornecedores](https://docs.google.com/uc?id=1m4QEhJTPjvp-EJ_U5YDVBtwFdq7iaxHS)
