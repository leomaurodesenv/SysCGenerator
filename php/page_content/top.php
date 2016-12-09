
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Leonardo Mauro">
    <link rel="icon" type="image/png" href="<?php echo def_path_online; ?>/image/favicon.png">
    <link rel="icon" type="image/x-icon" href="<?php echo def_path_online; ?>/image/favicon.ico">

    <title>SysCGenerator</title>

    <!-- Custom styles for this template -->
    <link href="<?php echo def_path_online; ?>/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo def_path_online; ?>/css/bootswatch.min.css" rel="stylesheet">
	<link href="<?php echo def_path_online; ?>/css/style.css" rel="stylesheet">

	<script src="<?php echo def_path_online; ?>/js/jquery.min.js"></script>
	<script src="<?php echo def_path_online; ?>/js/jquery.validate.min.js"></script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="loading">
	<div class="img">
	<img src="<?php echo def_path_online; ?>/image/loading.gif" alt="" title="" />
	</div>
</div>

<div class="navbar navbar-default navbar-static-top" id="top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?php echo def_home_href; ?>" class="navbar-brand"><i class="fa fa-cubes"></i> SysCGenerator</a>
    </div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Autenticação <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo def_path_online; ?>/verify.php">Autenticar Certificado</a></li>
            <li><a href="<?php echo def_path_online; ?>/list.php">Lista de Eventos</a></li>
          </ul>
        </li>
		<?php if(acess_login()){ ?>
			<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerência <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo def_path_online; ?>/pages/event/list.php">Eventos</a></li>
            <li><a href="<?php echo def_path_online; ?>/pages/participants/list.php">Participantes</a></li>
          </ul>
        </li>
			<li><a href="<?php echo def_path_online; ?>/php/connection/logout.php">Sair</a></li>
		<?php } else { ?>
			<li><a href="<?php echo def_path_online; ?>/login.php">Login</a></li>
		<?php }?>
      </ul>
	</div>
	</div>
	
</div> <!-- /navbar -->
