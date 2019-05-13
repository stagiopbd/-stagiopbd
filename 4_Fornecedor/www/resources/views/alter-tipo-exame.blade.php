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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> 

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="{{URL::asset('css/style.css')}}" rel="stylesheet" type="text/css" />       

        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{URL::asset('js/ajax.js')}}"></script>
        <script language="JavaScript" type="text/javascript" src="{{URL::asset('js/MascaraValidacao.js')}}"></script> 

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
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" 
               data-dismiss="alert"
               aria-label="close">&times;</a>
            {{ session('error') }}
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
                        <h1><b>Tipo de Exame</b></h1>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="">Home</a></li>                  
                            <li><a href="{{route('tipoexame.index')}}">Tipos de Exame</a></li>                  
                            <li class="active">Cadastro</li>
                        </ol>              
                    </div>          
                </div>
                <div class="row">  
                    <br>
                    <h4 id="center"><b>ALTERAÇÃO DE TIPO DE EXAME</b></h4>
                    <br> 
                    <form method="post" 
                          action="{{route('tipoexame.update', $tipo_de_exame->ext_id)}}" 
                          enctype="multipart/form-data">
                        {!! method_field('put') !!}
                        {{ csrf_field() }}
                        <div class="col-md-6">              
                            <div class="form-group">
                                <label for="grupo_exame">Grupo</label>
                                <select name="grupo_exame" class="form-control">
                                @foreach($grupos_de_exame as $grupo)
                                <option value="{{$grupo->exg_id}}">{{$grupo->exg_name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subitem_exame">Subitem</label>
                                <select name="subitem_exame" class="form-control">
                                @foreach($subitens_de_exame as $subitem)
                                <option value="{{$subitem->exs_id}}">{{$subitem->exs_name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo_exame">Código</label>
                                <input maxlength="15" type="text" name="codigo_exame" 
                                       class="form-control" 
                                       value="{{$tipo_de_exame->ext_code}}"
                                       required>
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descricao_exame">Descrição</label>
                                <input maxlength="100" type="text" name="descricao_exame"
                                       class="form-control"
                                       value="{{$tipo_de_exame->ext_description}}"
                                       required>
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tecnica_exame">Técnica</label>
                                <input maxlength="45" type="text" name="tecnica_exame" 
                                       class="form-control" 
                                       value="{{$tipo_de_exame->ext_technical}}"
                                       required>
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="indicacao_exame">Indicação</label>
                                <input maxlength="45" type="text" name="indicacao_exame" 
                                       class="form-control" 
                                       value="{{$tipo_de_exame->ext_indication}}"
                                       required>
                            </div>    
                        </div>
                        <div class="form-group">
                            <label for="detalhes_exame">Detalhes do exame</label>
                            <textarea class="form-control" name="detalhes_exame" rows="3">{{$tipo_de_exame->ext_details}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="param_inicial_input">Parâmetro Inicial</label>
                                <input type="range" name="param_inicial_input" id="param_inicial_input_id" value="{{$tipo_de_exame->ext_paraminitial}}" min="0" max="1" step=0.1 oninput="param_inicial_output_id.value = param_inicial_input_id.value" 
                                       class="form-control" 
                                       required>
                                <output name="param_inicial_output" id="param_inicial_output_id">{{$tipo_de_exame->ext_paraminitial}}</output>
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="param_final_input">Parâmetro Final</label>
                                <input type="range" name="param_final_input" id="param_final_input_id" value="{{$tipo_de_exame->ext_paramfinal}}" min="0" max="1" step=0.1 oninput="param_final_output_id.value = param_final_input_id.value" 
                                       class="form-control" 
                                       required>
                                <output name="param_final_output" id="param_final_output_id">{{$tipo_de_exame->ext_paramfinal}}</output>
                            </div>    
                        </div>                               
                        <div class="col-md-12">                   
                            <button type="reset" class="btn btn-default">
                                Limpar
                            </button>
                            <button type="submit" 
                                    class="btn btn-warning" id="black">
                                Alterar
                            </button>
                        </div>
                    </form>             
                </div>
            </div>
        </div>
    </body>
</html>