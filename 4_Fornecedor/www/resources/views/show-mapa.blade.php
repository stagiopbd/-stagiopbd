<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet.awesome-markers@2.0.4/dist/leaflet.awesome-markers.css" />
    <script src="https://unpkg.com/leaflet.awesome-markers@2.0.4/dist/leaflet.awesome-markers.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">


	<style>
		#location-map{
			position: static;
  			top: 0px;
			background: #fff;
			border: none;
			height: 100vh;
			width: 100%;
			box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
		}
	</style>

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
	<br><br><br>
	<!-- This is new -->
	<div class="btn-group">
		<button type="button" id="allbus" class="btn btn-primary">Tudo</button>
		<button type="button" id="others" class="btn btn-success">Normal</button>
		<button type="button" id="cafes" class="btn btn-danger">Alerta</button>
	</div>
	<div id="location-map">
	</div>
	<script type="text/javascript">
		var map = L.map('location-map').setView([-23.221070, -45.909340], 15);
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
		mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
		var layerGroupRed = L.layerGroup()
		var layerGroupGreen = L.layerGroup()
		@foreach($pacientes_com_sarampo as $paciente)
		lat = {{(float) str_replace(',', '.', $paciente->value('z.lat'))}}
		long = {{(float) str_replace(',', '.', $paciente->value('z.long'))}}
		var number_total = {{count($paciente->value('collect(p.cpf)'))}}
		var number_infected = Math.floor(Math.random()*(number_total*0.06));
		//marker = new L.marker([lat,long]).addTo(map).bindPopup('Moradores: ' + number_total.toString() + '<br>' + 'Com Sarampo: ' + number_infected.toString()).openPopup()
		if(number_infected >= number_total*0.05){
			marker = new L.marker([lat,long], {icon: L.AwesomeMarkers.icon({icon: 'exclamation-triangle', prefix: 'fa', markerColor: 'red'}) }).bindPopup('Moradores: ' + number_total.toString() + '<br>' + 'Com Sarampo: ' + number_infected.toString());
			marker.addTo(layerGroupRed);
		}
		else{
			marker = new L.marker([lat,long], {icon: L.AwesomeMarkers.icon({icon: 'check-circle', prefix: 'fa', markerColor: 'green'}) }).bindPopup('Moradores: ' + number_total.toString() + '<br>' + 'Com Sarampo: ' + number_infected.toString());
			marker.addTo(layerGroupGreen);
		}
		@endforeach
		layerGroupGreen.addTo(map);
		layerGroupRed.addTo(map);
		// The JavaScript below is new
        $("#others").click(function() {
            map.addLayer(layerGroupGreen)
            map.removeLayer(layerGroupRed)
        });
        $("#cafes").click(function() {
            map.addLayer(layerGroupRed)
            map.removeLayer(layerGroupGreen)
        });
        $("#allbus").click(function() {
            map.addLayer(layerGroupGreen)
            map.addLayer(layerGroupRed)
        });
	</script>
</body>
</html>