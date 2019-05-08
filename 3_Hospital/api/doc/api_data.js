define({ "api": [
  {
    "type": "get",
    "url": "/especialidade/new",
    "title": "02-Cadastrar",
    "name": "exports_cadastro",
    "group": "Especialidade",
    "description": "<p>Disponibiliza um formulário HTML para o cadastro das seguintes informações de um especialidade.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Descricao",
            "description": "<p>Descrição da Especialidade</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/especialidade-controller.js",
    "groupTitle": "Especialidade"
  },
  {
    "type": "get",
    "url": "/especialidade/delete/:id",
    "title": "05-Remover",
    "name": "exports_delete",
    "group": "Especialidade",
    "description": "<p>Remove um especialidade do banco de dados. Em caso de sucesso, redirecionao o usuário à lista de especialidades.</p>",
    "version": "0.0.0",
    "filename": "controllers/especialidade-controller.js",
    "groupTitle": "Especialidade"
  },
  {
    "type": "get",
    "url": "/especialidade",
    "title": "01-Listar",
    "name": "exports_get",
    "group": "Especialidade",
    "description": "<p>Retorna uma tabela HTML contendo os campos</p> <p>Para cada registro, além das informações especificadas abaixo, há ainda <em>links</em> para edição e remoção do respectivo registro.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>Identificador único do especialidade</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Descricao",
            "description": "<p>Descrição da Especialidade</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/especialidade-controller.js",
    "groupTitle": "Especialidade"
  },
  {
    "type": "post",
    "url": "/especialidade/",
    "title": "03-Inserir",
    "name": "exports_post",
    "group": "Especialidade",
    "description": "<p>Insere informações de um especialidade no banco de dados. Em caso de sucesso, redirecionao o usuário à lista de especialidades.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputDesc",
            "description": "<p>Descrição da Especialidade</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/especialidade-controller.js",
    "groupTitle": "Especialidade"
  },
  {
    "type": "post",
    "url": "/especialidade/update/edit/:id",
    "title": "04-Atualizar",
    "name": "exports_update",
    "group": "Especialidade",
    "description": "<p>Atualiza informações de um especialidade no banco de dados. Em caso de sucesso, redirecionao o usuário à lista de especialidades.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputDesc",
            "description": "<p>Descrição da Especialidade</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/especialidade-controller.js",
    "groupTitle": "Especialidade"
  },
  {
    "type": "get",
    "url": "/hospital/new",
    "title": "02-Cadastrar",
    "name": "exports_cadastro",
    "group": "Hospital",
    "description": "<p>Disponibiliza um formulário HTML para o cadastro das seguintes informações de um hospital.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Nome",
            "description": "<p>Nome do Hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "CNPJ",
            "description": "<p>CNPJ do Hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Endereco",
            "description": "<p>Endereço completo do Hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Telefone",
            "description": "<p>Telefone do Hospital</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/hospital-controller.js",
    "groupTitle": "Hospital"
  },
  {
    "type": "get",
    "url": "/hospital/delete/:id",
    "title": "05-Desabilitar",
    "name": "exports_delete",
    "group": "Hospital",
    "description": "<p>Desabilita um hospital no banco de dados. Em caso de sucesso, redirecionao o usuário à lista de hospitais.</p>",
    "version": "0.0.0",
    "filename": "controllers/hospital-controller.js",
    "groupTitle": "Hospital"
  },
  {
    "type": "get",
    "url": "/hospital",
    "title": "01-Listar",
    "name": "exports_get",
    "group": "Hospital",
    "description": "<p>Retorna uma tabela HTML contendo os campos</p> <p>Para cada registro, além das informações especificadas abaixo, há ainda <em>links</em> para edição e remoção do respectivo registro.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "ID",
            "description": "<p>Identificador único do hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Nome",
            "description": "<p>Nome do Hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "CNPJ",
            "description": "<p>CNPJ do Hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Endereco",
            "description": "<p>Endereço completo do Hospital</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Telefone",
            "description": "<p>Telefone do Hospital</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/hospital-controller.js",
    "groupTitle": "Hospital"
  },
  {
    "type": "post",
    "url": "/hospital/",
    "title": "03-Inserir",
    "name": "exports_post",
    "group": "Hospital",
    "description": "<p>Insere informações de um hospital no banco de dados. Em caso de sucesso, redirecionao o usuário à lista de hospitais.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputNome",
            "description": "<p>Nome do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputCnpj",
            "description": "<p>CNPJ do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputAddress",
            "description": "<p>Endereço completo do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputPhone",
            "description": "<p>Telefone do Hospital</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/hospital-controller.js",
    "groupTitle": "Hospital"
  },
  {
    "type": "post",
    "url": "/hospital/update/edit/:id",
    "title": "04-Atualizar",
    "name": "exports_update",
    "group": "Hospital",
    "description": "<p>Atualiza informações de um hospital no banco de dados. Em caso de sucesso, redirecionao o usuário à lista de hospitais.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputNome",
            "description": "<p>Nome do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputCnpj",
            "description": "<p>CNPJ do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputAddress",
            "description": "<p>Endereço completo do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inputPhone",
            "description": "<p>Telefone do Hospital</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inputSituation",
            "description": "<p>Situacao do Hospital</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "controllers/hospital-controller.js",
    "groupTitle": "Hospital"
  }
] });
