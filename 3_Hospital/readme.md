# TIME 03 Scrum -  ITA

## Integrantes do Time: 

####  Scrum Master:

* RICARDO Ribeiro de Alvarenga (Mest-AO) - CE-229

####  Development Team:

* LUCIANA Kfouri - CE 240/245 
* CLÁUDIO Alexandre de Costa Dias - CE 229
* Leonardo GUIMARÃES (Mest-AO) - CE 229
* JULIO CESAR de Paiva Ribeiro  - CE 245 
* FABIO - CE-240

## Link Aplicação

https://stagiopbd-hospital.herokuapp.com/

## Projeto -  Segmento "Hospital"


### Tutorial para iniciar a aplicação.

#### Passo 1:

##### Download da Aplicação e artefatos:

Faça Download/Clone o repositório do git em sua máquina de desenvolvimento
```
 git clone https://github.com/stagiopbd/ipbl2019.git
```

#### Passo 2:

#####  Banco de Dados (Mysql):

Crie a base de dados:
```
 create database stagiop;
```
Após a criação do Banco de Dados disponibilizado o Script que se encontra na pasta (3_Hospital/public/database/)


#### Passo 3:

#####  Rodando Aplicação:

Para executar a aplicação será necessário realizar os seguintes passos:

Na pasta raiz da aplicação "3_Hospital/"
execute o comando:
```
 npm install --save
```
para instalar as depencias da aplicação.


Em seguida execute o comando: 
```
 npm start
```
para executar a aplicação.

Assim será necessário abrir o navegador e acessar a url:
> http://localhost:3000/

ou 

[Aplicação](http://localhost:3000/)



#### Atualizando aplicação no "Heroku"

#####  Passo 1:

Instale o heroku cli em sua máquina:

[doc Heroku: ](https://devcenter.heroku.com/articles/heroku-cli)

 - Instalação linux: 

```
$ sudo snap install --classic heroku
```
 - Instalação MacOs: 
```
$ brew tap heroku/brew && brew install heroku
```

#### Passo 2 

Com seu repositório atualizado navegue até a pasta da api usando seu terminal: cd  /ipbl2019/3_Hospital/api
 &

Execute o comando de login no Heroku:
```
$ heroku login 
```

#### Passo 3

Agora precisamos somente atualizar o repositório no heroku para que a aplicação seja atualiza.

Execute os seguintes comandos:

 - Verifique os arquivos que foram atualizados:
```
$ git status
```

 - Use . no final do comando para adicionar "Todos"  ou especcifique o nome do arquivo
```
$ git add .
```
ou

```
$ git add <file>
```

 - Salve as alterações. (Não esqueça de comentar a respeito da atualização)
```
$ git commit -am "Seu comentário"
```

 - Por fim, atualize o repositório para que o Deploy seja executado.
```
$ git push heroku master
```






