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
                        <h1><b>Tipos de Exame</b></h1>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>                  
                            <li class="active">Tipos de Exame</li>
                        </ol>
                        <br>
                        <a href="{{route('tipoexame.create')}}" 
                           class="btn btn-default btn-sm pull-right">
                            <span class="glyphicon glyphicon-plus"></span> Adicionar</a>
                        <a href="" 
                           class="btn btn-default btn-sm pull-right">
                            <i class="fa fa-book"></i> Relatório</a>
                        <div id="pesquisa" class="pull-right">
                            <form class="form-group" method="get" 
                                  action="/tipoexame/search">                          
                                <input type="text" name="descricao_exame" 
                                       class="form-control input-sm pull-left" 
                                       placeholder="Pesquisar por descrição..." required> 
                                <button class="btn btn-default btn-sm pull-right" 
                                        id="color"> 
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </form>
                        </div>
                    </div>           
                </div>
                <div class="row">
                    <div class="col-md-12">   
                        <br />
                        <h4 id="center"><b>TIPOS DE EXAME CADASTRADOS ({{$total}})</b></h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
										<th id="center">ID</th>
                                        <th id="center">Grupo</th>
                                        <th id="center">Subitem</th>
                                        <th id="center">Código</th>
                                        <th id="center">Descrição</th>
                                        <th id="center">Técnica</th>
                                        <th id="center">Indicação</th>
                                        <th id="center">Inicial</th>
                                        <th id="center">Final</th>
										<th id="center">Ações</th>  										
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tipos_de_exame as $tipo)
                                    <tr>
									    <td tile="ID" id="center">{{$tipo->ext_id}}</td>
                                        <td title="Grupo" id="center">{{$tipo->tipo_grupo_exame->exg_name}}</td>
                                        <td title="Subitem" id="center">{{$tipo->tipo_exame_subitem->exs_name}}</td>
                                        <td title="Código" id="center">{{$tipo->ext_code}}</td>
                                        <td title="Descrição" id="center">{{$tipo->ext_description}}</td>
                                        <td title="Técnica" id="center">{{$tipo->ext_technical}}</td>
                                        <td title="Indicação" id="center">{{$tipo->ext_indication}}</td>
                                        <td title="Inicial" id="center">{{$tipo->ext_paraminitial}}</td>
                                        <td title="Final" id="center">{{$tipo->ext_paramfinal}}</td>
                                        <td id="center">
                                            <a href="{{route('tipoexame.edit', $tipo->ext_id)}}" 
                                               data-toggle="tooltip" 
                                               data-placement="top"
                                               title="Alterar"><i class="fa fa-pencil"></i></a>
                                            &nbsp;<form style="display: inline-block;" method="POST" 
                                                        action="{{route('tipoexame.destroy', $tipo->ext_id)}}"                                                        
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Excluir" 
                                                        onsubmit="return confirm('Confirma exclusão?')">
                                                {{method_field('DELETE')}}{{ csrf_field() }}                                                
                                                <button type="submit" style="background-color: #fff">
                                                    <a><i class="fa fa-trash-o"></i></a> 
                                                </button></form></td>               
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $tipos_de_exame->links() }}
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

