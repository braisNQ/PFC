<?php include("header.php"); ?>

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
            <li class="active"><a href="usuarios.php">Usuarios</a></li>
            <li><a href="equipos.php">Equipos</a></li>
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

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Usuarios</h1>
        
<?php

include('clase_usuario.php');

echo "asd";
$p = new prueba;
$p->escribe();

echo "cvb";

echo "<br>";

$usu = "<>?!/'usuariods\"";
$cont = "asda''das?¿et";

echo $usu . "<br>" . mysql_real_escape_string($usu);
echo "<br>";
echo $cont . "<br>" . mysql_real_escape_string($cont);
echo "<br>";
 
$consulta = sprintf("SELECT * FROM users WHERE user='%s' AND password='%s'",
 					mysql_real_escape_string($usu),
 					mysql_real_escape_string($cont)
			);
 
 echo $consulta;

?>
        <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>To see the difference between static and fixed top navbars, just scroll.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
        </p>
      </div>



  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>