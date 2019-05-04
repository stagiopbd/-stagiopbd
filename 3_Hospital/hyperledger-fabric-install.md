# Instalação :  Hyperledger fabric

### Pré requisitos de ambiente:
 - Sistema Operacional : linux (ubuntu) 14.04 / 16.04 LTS (both 64-bit)
 - Memória RAM : 4GB (min)
 - Disco HD/SSD : 50GB (recomendado)

### Passo 1:

Para que seja possível executar alguns passos abaixo, será necessário obter o curl instlado na máquina. Se não tiver o mesmo  instalado, basta apenas abrir o terminal e digitar:
```
 sudo apt install curl 
```

### Passo 2:

Já executado o primeiro passo, com o "Terminal" vamos seguir com o processo da instalação. 

#### Instalando os requisitos de ambiente


- Docker Engine: Version 17.03 ou superior
- Docker-Compose: Version 1.8 ou superior
- Node: 8.9 ou superior 
- npm: v5.x
- git: 2.9.x ou superior
- Python: 2.7.x
- Um editor de texto, nós recomendamos VSCode.

O pessoal responsável pela criação Hyperledger Composer, liberou um "shell" para a instalação de alguns componentes citados acima.

Rode o comando abaixo para baixar o arquivo "shell""

````
 curl -O https://hyperledger.github.io/composer/latest/prereqs-ubuntu.sh

chmod u+x prereqs-ubuntu.sh
````

Depois de baixar o arquivo e dar as devidas permissões, devemos apenas executa-lo e aguardar a instalação:

````
./prereqs-ubuntu.sh
````

Após o passo acima, devemos instalar o NodeJs e o NPM 

````
sudo apt install nodejs
````
&
````
sudo apt install npm
````

Com todas as ferramentas instaladas, vamos validar se todos os itens foram instalados:

````
node --version
npm -- version
docker-compose --version 
docker --version
````

### Passo 3

#### Preparando o ambiente de desenvolvimento

Agora vamos iniciar a instalação das ferramentas de client do Hyperledger.

1. Essential CLI tools:

````
npm install -g composer-cli@0.20
````
2. Utilitário para executar um servidor REST em sua máquina para expor suas redes de negócios como APIs RESTful:

````
npm install -g composer-rest-server@0.20
````
3. Utilitário útil para gerar ativos de aplicativos:

````
npm install -g generator-hyperledger-composer@0.20
````
4. Yeoman é uma ferramenta para geração de aplicativos, que utilizam generator-hyperledger-composer:

````
npm install -g yo
````

### Passo 3 

#### Instalando o Playground (Web App)

1.  Esse aplicativo é utilizado para fazer pequenos testes e edição das Business Networks

````
npm install -g composer-playground@0.20
````

### Passo 4

#### Instalação do Hyperledger Fabric 

Esta etapa fornece nó de execução local do Hyperledger Fabric para implantar suas Business Networks.

1.  Fazendo o download dos componentes para iniciar o download Hyperledger Fabric: 

````
mkdir ~/fabric-dev-servers && cd ~/fabric-dev-servers

curl -O https://raw.githubusercontent.com/hyperledger/composer-tools/master/packages/fabric-dev-servers/fabric-dev-servers.tar.gz
tar -xvf fabric-dev-servers.tar.gz
````

2. Após baixados os scripts (lembre de estar dentro da pasta ~/fabric-dev-servers ), execute o comando abaixo:

````
cd ~/fabric-dev-servers
export FABRIC_VERSION=hlfv12
./downloadFabric.sh
````


### Passo 5

#### Iniciando o Hyperledger e criando uma card

Execute o comando abaixo para iniciar sua blockchain "Fabric" e criar seu card de acesso (perfil de acesso para controle da rede)

````
 cd ~/fabric-dev-servers
    export FABRIC_VERSION=hlfv12
    ./startFabric.sh
    ./createPeerAdminCard.sh
````

Para parar e executar sua rede você pode executar os arquivos .sh que se encontram dentro da pasta: /fabric-dev-servers

Parar:
````
./stopFabric.sh
````

Iniciar:
````
./startFabric.sh
````

### Passo 6 

#### Iniciando a aplicação do composer para gerenciar sua rede

Para ligar a aplicação web do composer, basta somente executar o comando abaixo:

````
composer-playground
````

Feito isso, você precisa abrir seu navegador e acessar a url: 

https://localhost:8080/login


Protinho, agora é só trabalhar.

Good Works!





