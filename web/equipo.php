<?php include("header.php"); ?>

<?php
	if(isset($_GET['id']))
		$id = $_GET['id'];
	
	$user = new usuario($id);
?>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">PFC</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="usuarios.php">Usuarios</a></li>
            <li class="active"><a href="equipos.php">Equipos</a></li>
            <li><a href="torneos.php">Torneos</a></li>            
          </ul>
          
          <ul class="nav navbar-nav navbar-right">          	
          	<?php include("login.php"); ?>
          	
<!-- /ul /div /div /div dentro de login.php
          </ul>
        </div><!--/.nav-collapse -->
<!--
      </div>
    </div>
    -->

	<div class="container">
		<div class="jumbotron">
<?php
	//se está logueado e non ten equipo
	if(isset($_SESSION['ID']) && !$usuarioActual->getIDequipo())
	{
		aviso("info", "Parece que non pertences a ning&uacute;n equipo....", "crearequipo.php", "Crear equipo");
	}
	
	
?>
        	
		</div>
	</div>

	
	
	
	



<?php include("footer.php"); ?>