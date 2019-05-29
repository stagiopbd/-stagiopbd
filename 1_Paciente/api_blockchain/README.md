# API BLOCKCHAIN

API para a inserção e recuperação de informações no blockchain e influxDB.

Para rodar a API você possui duas opções:
  - via docker
  - via npm

Caso escolha via docker:
```sh
sudo docker pull gustavogomides/api-stagiopbd-blockchain
sudo docker run -d -p 3007:3007 api-stagiopbd-blockchain
```

Caso escolha via npm:
```sh
npm install
npm start
```

## Documentação dos endpoints


### CADASTRAR NOTIFICAÇÕES

```sh
POST - http://localhost:3007/notifications
```

#### BODY

```json
{
	"notificationId": "1234",
    "type": "notification",
    "from": "patient",
    "to": "hospital",
    "datetime": "29/05/2019 19:17:00",
    "title": "Consulta",
    "text": "Consulta",
    "protocol": "normal"
}
``` 