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
                            <li><a href="{{route('exame.index')}}">Exames</a></li>
                            <li><a href="{{route('fornecedor.index')}}">Fornecedores</a></li>                  
                            <li><a href="#">Hospital</a></li>  
                            <li><a href="{{route('mapa.index')}}">Mapa</a></li>                         
                            <li><a href="{{route('medicamento.index')}}">Medicamentos</a></li>                                                
                            <li><a href="#">Médicos</a></li>
                            <li><a href="#">Pacientes</a></li>
                            <li><a href="{{route('tipoexame.index')}}">Tipos de Exame</a></li>  
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
                    <div class="col text-center">
                    <img src="{{url('/img/tipoexame.png')}}" width="100" height="100" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="center"> 
                        <h1><b>Requisições de Exame</b></h1>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>                  
                            <li class="active">Requisições de Exame</li>
                        </ol>
                        <br>
                    </div>           
                </div>

                <div id="pesquisa" class="pull-right">
                    <form class="form-group" method="get" 
                            action="/exame/search">                                
                        <input type="text" name="patcpf" 
                                class="form-control input-sm pull-left" 
                                placeholder="Pesquisar por CPF do paciente..." required> 
                        <button type=submit class="btn btn-default btn-sm pull-right" 
                                id="color"> 
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-12">   
                        <br />
                        <h4 id="center"><b>REQUISIÇÕES DE EXAME ({{$total}})</b></h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
										<th id="center">ID</th>
                                        <th id="center">Paciente</th>
                                        <th id="center">Médico</th>
                                        <th id="center">Data Solicitação</th>
                                        <th id="center">Resultado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exames as $exame)
                                    <tr>
									    <td tile="ID" id="center">{{$exame->exr_id}}</td>
                                        <td title="Paciente" id="center">{{$exame->exr_pat_cpf}}</td>
                                        <td title="Médico" id="center">{{$exame->exr_phy_cpf}}</td>
                                        <td title="Data Solicitação" id="center">{{$exame->exr_date_request}}</td>
                                        <td title="Resultado" id="center">{{$exame->exr_result}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $exames->links() }}
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

