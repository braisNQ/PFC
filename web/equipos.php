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

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
       
<?php

if (!isset($_GET['pax']))
	$_GET['pax'] = 1;
$pax = $_GET['pax'];

echo "		<ul class='pagination'>";
if($pax == 1)
	echo "	  <li class='disabled'><a href='#'>&laquo;</a></li>";
else
	echo "	  <li><a href='?pax=".(int)$pax -1 ."'>&laquo;</a></li>";
	
	for($i=1; $i<=5; $i++)
	{
		if($i == $pax)
			echo "<li class='active'><a href='#'>$i</a></li>";
		else
			echo "<li><a href='?pax=$i'>$i</a></li>";
		
	}
echo "		  <li><a href='#'>&raquo;</a></li>";
echo "		</ul>";

?>
       
       
       
       
       
       
      </div>  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>