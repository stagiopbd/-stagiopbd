<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>STAGIOP-BD</title>
        
        <!-- Favicon -->
        <link href="{{URL::asset('img/favicon.ico')}}" rel="shortcut icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> 

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="{{URL::asset('css/style.css')}}" rel="stylesheet" type="text/css" /> 
        <link href="{{URL::asset('css/lightbox.css')}}" rel="stylesheet" type="text/css" /> 

        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{URL::asset('js/ajax.js')}}"></script>
        <script src="{{URL::asset('js/lightbox.js')}}"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">       
            <div class="navbar-header">
                <a class="navbar-brand" href="{{url('/')}}" 
                   title="Página Inicial" style="margin-top: -3px">
                    <img src="{{URL::asset('img/logo_gpes.png')}}"></a>
                <button type="button" class="navbar-toggle" 
                        data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>               
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav" id="link-white">
                    <li>
                        <a href="#" style="text-decoration: none">
                            <span class="glyphicon glyphicon-home"></span> 
                            <span id="underline">Home</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" 
                           href="#" style="text-decoration: none">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span id="underline">Cadastros</span> 
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">                           
                            <li><a href="#">Usuários</a></li> 
                            <li><a href="{{route('fornecedor.index')}}">Fornecedores</a></li>                                               
                            <li><a href="{{route('tipoexame.index')}}">Tipos de Exame</a></li>                                              
                            <li><a href="{{route('medicamento.index')}}">Medicamentos</a></li>                                               
                            <li><a href="#">Médicos</a></li>
                            <li><a href="#">Pacientes</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" 
                           href="#" style="text-decoration: none">
                            <span class="glyphicon glyphicon-th"></span> 
                            <span id="underline">Utilitários</span>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">                           
                            <li>
                                <a href="#">Gerar relatório</a>
                            </li>                             
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" id="link-white">
                    <li class="dropdown">
                        <a href="#" style="text-decoration: none">
                            <img src="{{URL::asset('img/gerente.jpg')}}" 
                                 class="img-circle" width="26" height="26" 
                                 style="margin-top: -3px"> 
                            <span id="underline">Gerente</span> 
                        </a>                      
                    </li>
                    <li><a href="#" 
                           style="text-decoration: none">
                            <span class="glyphicon glyphicon-log-in"></span> 
                            <span id="underline">Sair</span></a></li>  
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                </ul>
            </div>       
        </nav> 
        @if (session('message'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" 
               data-dismiss="alert"
               aria-label="close">&times;</a>
            {{ session('message') }}
        </div>
        @endif
        <div id="line-one">   
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="center"> 
                        <h1><b>Medicamentos</b></h1>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>                  
                            <li class="active">Medicamentos</li>
                        </ol>
                        <br>
                    </div>           
                </div>

                <div id="pesquisa" class="pull-right">
                    <form class="form-group" method="get" 
                            action="/medicamento/search">                                
                        <input type="text" name="descricao" 
                                class="form-control input-sm pull-left" 
                                placeholder="Pesquisar por descrição..." required> 
                        <button type=submit class="btn btn-default btn-sm pull-right" 
                                id="color"> 
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-12">   
                        <br />
                        <h4 id="center"><b>MEDICAMENTOS CADASTRADOS ({{$total}})</b></h4>
                        <br>
                        Filtros de Tarja:
                        <a href="/medicamento?tarja=1">Tarja Preta</a> |
                        <a href="/medicamento?tarja=2">Tarja Vermelha</a> |
                        <a href="/medicamento?tarja=3">Venda Livre</a> |
                        <a href="/medicamento">Limpar filtro</a>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
										<th id="center">ID</th>
                                        <th id="center">Descrição</th>
                                        <th id="center">Fabricante</th>
                                        <th id="center">Classe</th>
                                        <th id="center">Tipo</th>
                                        <th id="center">Tarja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicamentos as $medicamento)
                                    <tr>
									    <td tile="ID" id="center">{{$medicamento->med_id}}</td>
                                        <td title="Descrição" id="center">{{$medicamento->med_product_description}}</td>
                                        <td title="Fabricante" id="center">{{$medicamento->fornecedor->sup_fantasy_name}}</td>
                                        <td title="Classe" id="center">{{$medicamento->classe_terapeutica->thc_code}}</td>
                                        <td title="Tipo" id="center">{{$medicamento->tipo_produto->pdt_description}}</td>
                                        <td title="Tarja" id="center">{{$medicamento->tarja->stp_description}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $medicamentos->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{URL::asset('img/subir.png')}}" 
                 id="up" 
                 style="display: none;" 
                 alt="Ícone Subir ao Topo" 
                 title="Subir ao topo?">
            </body>
            </html>

