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

### INSTALAÇÃO LOCAL (WINDOWS)

No momento o produto criado ainda não foi hospedado em serviços de Nuvem como Heroku ou outros. Para visualizar as telas do sistema, e interagir com o mesmo, é necessário fazer uma instalação local.

#### Passo 1: Instalar os softwares básicos de PHP/MySQL/Webserver

Recomendamos a utilização de softwares integrados com todas as tecnologias necessárias.
Em sistemas Windows é relativamente fácil fazer essa instalação.
* Opção 1 (Xampp): https://www.apachefriends.org/pt_br/index.html
* Opção 2 (Wamp): http://www.wampserver.com/en/

#### Passo 2: Instalar o gerenciador de dependências Composer (PHP)

Esse projeto também depende do gerenciador de dependências Composer. Esse gerenciador é responsável por facilitar a instalação das diversas bibliotecas necessárias para o projeto.
* Link oficial (Composer): https://getcomposer.org/download/

#### Passo 3: Instalação do Laravel via Composer

Com o Composer instalado é possível instalar o Laravel, via PowerShell no caso de sistemas Windows mais recentes, com o seguinte comando:
```
composer global require laravel/installer
```
Após essa instalação, é necessário fazer uma pequena alteração na variável de ambiente $PATH do sistema operacional. No caso de sistemas Windows essa variável fica em: Sistema->Configurações avançados do sistema->Variáveis de ambiente. Não deve sobrescrever, apenas acrescentar ao final o caminho de instalação do Laravel. Exemplo de como fica o final da variável $PATH após instalação do Composer e Laravel.

```
C:\ProgramData\ComposerSetup\bin;C:\Users\André\AppData\Roaming\Composer\vendor\bin
```
#### Passo 4: Deploy local da aplicação no servidor web
Entre na pasta principal, ou onde preferir, no seu servidor web. Em geral o nome desse diretório é "www". Exemplo de acesso ao diretório principal do Wamp:
```
cd C:\wamp64\www
```
Crie um novo diretório para o projeto com Laravel, escolhendo o nome que preferir. Por exemplo, se desejarmos criar um novo site com o nome "stagiopbd-fornecedor":
```
laravel new stagiopbd-fornecedor
```
O comando acima irá instalar diversos pacotes dentro desse diretório. Por fim, basta substituir todos os arquivo dentro desse diretório pelos arquivos que estão disponibilizados aqui no repositório do GitHub.

#### Passo 4: Configuração de conexão com o banco de dados MySQL
Altere o arquivo .env dentro do diretório do projeto e inclua configurações adequadas de conexão com um banco de dados MySQL. As variáveis que devem ser alteradas são:
* DB_CONNECTION
* DB_HOST
* DB_PORT
* DB_DATABASE
* DB_USERNAME
* DB_PASSWORD
    
Esse banco inicialmente pode não ter tabela nenhuma, pois essas tabelas são criadas automaticamente com a execução do seguinte comando:
```
php artisan migrate
```
E após esse comando todas as tabelas terão sido criadas no banco de dados especificado. Essas tabelas estarão inicialmente vazias, então pode ser necessário cadastrar algumas informações usando scripts .SQL.

#### Passo 5: Executando a aplicação
Execute a aplicação com o seguinte comando:
```
php artisan serve
```
A aplicação estará disponível em:
```
http://127.0.0.1:8000/
```
![Página principal](https://docs.google.com/uc?id=1gYAEUoM1NlzGgTEYPMnxDpE0GVupN_1d)
![Cadastro de fornecedor](https://docs.google.com/uc?id=193TEJOeIzXoxcds2a7x0R4u4R7r6A6k5)
![Listagem de fornecedores](https://docs.google.com/uc?id=1m4QEhJTPjvp-EJ_U5YDVBtwFdq7iaxHS)