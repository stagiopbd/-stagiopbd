# Biblioteca Laravel-Neo4J (Descrição e Instalação)

Para este projeto utilizamos a biblioteca Laravel-Neo4J, distribuída por Ahsan Abran no link https://github.com/AhsanAbrar/laravel-neo4j. Essa biblioteca é na verdade um wrapper para o Eloquent, que é o sistema facilitador de consultas do Laravel. Ou seja, com essa biblioteca você consegue fazer consultas em bancos Neo4J com a mesma facilidade que o Laravel proporciona para conectar e consultar em outros bancos através do módulo Eloquent. A biblioteca Laravel-Neo4J é uma extensão do GraphAware Neo4j PHP Client, disponível no link: https://github.com/graphaware/neo4j-php-client

### INSTALAÇÃO (LINUX/DOCKER)

Supondo que você já tenha um container com sua aplicação Laravel, a instalação é bastante simples.

#### Passo 1: Verifique as dependências

A única dependência que conhecemos é a extensão "bcmath" para o PHP.
Verifique se no arquivo Dockerfile ou em outras configurações do seu container essa extensão está habilitada.
* Antes: RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
* Depois: RUN docker-php-ext-install pdo_mysql mbstring bcmath zip exif pcntl

#### Passo 2: Se necessário, recrie o container

Pode ser necessário recriar o container, caso tenha incluído a extensão anteriormente.
Se seu container PHP já tinha essa extensão habilitada, ou se você instalou de outras formas, não é necessário recriar.
* Comando para recriar: docker-compose up -d --force-recreate --build nomedocontainer

#### Passo 3: Execute o comando para instalar a biblioteca via Composer

Utilizando o docker, é possível fazer essa instalação apenas com o comando abaixo.
```
docker-compose exec nomedocontainer composer require AhsanAbrar/laravel-neo4j
```
#### Passo 4: Criar arquivo config/cypher.php
Criar um arquivo "cypher.php" dentro do diretório "config" do Laravel e incluir o seguinte código:
```
<?php

return [
    'ssl' => false,
    'connection' => 'default',
    'host'   => env('DB_HOST_NEO', 'ip.do.servidor.neo4j'),
    'port'   => env('DB_PORT_NEO', 'porta'),
    'username' => env('DB_USERNAME_NEO', 'usuario'),
    'password' => env('DB_PASSWORD_NEO', 'senha')
];
```
Note que os nomes propositalmente terminam em "NEO" para diferenciar da configuração geral do banco principal.
Assim o código consegue entender que essa é uma configuração de um outro banco de dados.

#### Passo 5: Criação de um Controller (opcional)
Nesse ponto a biblioteca já está instalada e configurada.
Se quiser usar, você pode incluir a biblioteca num Controller já existente ou criar um novo Controller.
Abaixo segue exemplo de comando para criar um específico para uma aplicação de mapas:
```
docker-compose exec app php artisan make:controller MapaController
```

#### Passo 6: Exemplo de um Controller (opcional)
Execute a aplicação com o seguinte comando:
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;

class MapaController extends Controller
{
    /**
     * Display a map.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $dados = Cypher::run("MATCH (p:Patient)-[:HAS_ADDRESS]->(a:Address)-[:HAS_ZIPCODE]->(z:Zipcode) RETURN p.cpf, z.lat, z.long LIMIT 500")->getRecords();
        return view('show-mapa', compact('dados'));
    }
}
```

#### Passo 7: Demais configurações
Não esqueça de criar rotas no arquivo routes/web.php e uma nova view se achar necessário.
