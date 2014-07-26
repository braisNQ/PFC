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
        <h4>Equipos</h4>
       
<?php
	if(isset($_SESSION['ID']) && !$usuarioActual->getIDequipo())
	{
		echo '
			<div class="alert alert-info" role="alert">
				Parece que non pertences a ning&uacute;n equipo....
				<div class="text-center">			
					<a href="equipo.php?accion=crear" class="btn btn-success">Crear equipo</a>
				</div>
			</div>
		';
	}




	/*
	 * Variables default para o listado
	 */
	 $p = 1; //páxina listada
	 
	 $items = 10; //items listados por páxina
	 $orderby = "login";
	 $order = "asc"; //orden de listado
	 $nome='';
	 $membros= 1;  
 
	 /*
	  * recoller variables
	  */
	 if (isset($_POST['p']))
		$p = $_POST['p'];	 
	 if (isset($_POST['items']))
		$items = $_POST['items'];
	 if (isset($_POST['orderby']))
		$orderby = $_POST['orderby'];	 
	 if (isset($_POST['order']))
		$order = $_POST['order'];
	 if (isset($_POST['nome']))
		$nome = $_POST['nome'];
	 if (isset($_POST['membros']))
		$membros = $_POST['membros'];

	
?>	
	<div class="panel panel-default">
		<div class="panel-heading text-right">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapseForm">
  				Filtro <span class="caret"></span>
			</a>
		</div>
		<div id="collapseForm" class="panel-collapse collapse">
  			<div class="panel-body">
				<form class="form-horizontal" role="form" id="formFiltro" action="equipos.php" method="post">
					<input type="hidden" id="p" name="p" value="1">
					<div class="form-group">
						<label for="nome" class="col-sm-1 control-label input-sm">Nome</label>
					    <div class="col-sm-5">
							<input type="text" class="form-control input-sm" id="nome" name="nome" maxlength="50" value="<?php echo $nome;?>">
					    </div>
					    <label for="membros" class="col-sm-2 control-label input-sm">M&iacute;nimo membros</label>
					    <div class="col-sm-2">
							<input type="number" class="form-control input-sm" id="membros" name="membros" min="1" step="1" value="<?php echo $membros;?>">
					    </div>
					    <div class="col-sm-2"></div>
					</div>
					<div class="form-group">
						<label for="orderby" class="col-sm-2 control-label input-sm">Order by</label>
						<div class="col-sm-2">
							<select class="form-control input-sm" name="orderby" id="orderby">
							  <option value="nome" <?php if($orderby == "nome") echo "selected";?>>Nome</option>
							  <option value="membros" <?php if($orderby == "membros") echo "selected";?>>Membros</option>
							</select>
						</div>
						<label class="col-sm-1 control-label input-sm">Orde</label>
						<div class="col-sm-2">						
							<label class="radio-inline input-sm">
							  <input type="radio" name="order" id="orderAsc" value="asc" <?php if($order == "asc") echo "checked";?>> Asc
							</label>
							<label class="radio-inline input-sm">
							  <input type="radio" name="order" id="orderDesc" value="desc" <?php if($order == "desc") echo "checked";?>> Desc
							</label>
						</div>						
						<label for="items" class="col-sm-2 control-label input-sm">Resultados por p&aacute;xina</label>
					    <div class="col-sm-1">
							<input type="number" class="form-control input-sm" id="items" name="items" min="1" max="20" step="1" value="<?php echo $items;?>">
					    </div>	
					    
					    <div class="col-sm-2"></div>				    
					</div>
					<div class="form-group">						
					    <div class="col-sm-9"></div>
				    	<div class="col-sm-3">
				     		<button type="submit" class="btn btn-info btn-sm" name="accion" value="filtrar"><span class='glyphicon glyphicon-search'></span> Filtrar</button> 
				     		<a href="equipos.php" class="btn btn-default btn-sm"><span class='glyphicon glyphicon-trash'></span> Limpar</a>
				    	</div>
				  	</div>
				</form>
  			</div>
		</div>
	</div> 

<?php	 

	$bd = new bd();
	
	$nt = $bd->numeroEquipos();
	$nf = $bd->listarEquiposCont($nome, $membros);

	//calculos para paxinación
	$inicio = ($p - 1) * $items;
	$total_paxinas = ceil($nf / $items);
	
	$mostrando_inicio = intval($inicio +1);
	$mostrando_fin = intval($inicio + $items);
	
	if($mostrando_fin > $nf)
		$mostrando_fin = $mostrando_inicio + ($nf - $inicio -1);
	
	if($mostrando_inicio > $mostrando_fin)
		$mostrando_inicio = $mostrando_fin;
	
	$lista = $bd->listarEquipos($nome, $membros, $orderby, $order, $inicio, $items);
		
	echo "<span>Listando ".$mostrando_inicio." - ".$mostrando_fin." de ".intval($nf)." equipos filtrados.</span>";
	echo "<br />";
	echo "<span>Equipos totais: ".$nt."</span>";
	
	echo "
		<table class='table table-striped table-hover'>
			<tr>
				<th>Nome</th>
				<th>Membros</th>
				<th>&nbsp;</th>
			</tr>
	";

	if($lista->num_rows > 0)
	{
		while($row = $lista->fetch_assoc())
		{
			echo "<tr>";
				echo "<td><a href='equipo.php?id=".$row['ID']."'>".$row['nome']."</a></td>";	
				echo "<td>".$row['membros']."</td>";	
				echo "<td>";
					if(isset($_SESSION['ID']))
					{
						if($row['ID'] != $_SESSION['ID'])
							echo "<a class='btn btn-default btn-xs' href='mensaxes.php?id=".$row['ID']."'><span class='glyphicon glyphicon-envelope' data-toggle='tooltip' data-placement='top' title='Enviar mensaxe'></span></a> ";
						if(($row['ID'] == $_SESSION['ID']) || $usuarioActual->admin())
							echo "<a class='btn btn-default btn-xs' href='usuario.php?id=".$row['ID']."'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Editar perfil'></span></a> ";
						if($usuarioActual->admin())
							echo "<a class='btn btn-danger btn-xs' href='eliminarusuario.php?id=".$row['ID']."'><span class='glyphicon glyphicon-remove-sign' data-toggle='tooltip' data-placement='top' title='Eliminar usuario'></span></a> ";
					}
					
				echo "</td>";
			echo "</tr>";
		}
	}

	echo "</table>";
	
	//creando paxinación
	echo "		<ul class='pagination'>";
	if($p == 1)
	{
		echo "	  <li class='disabled'><a href='#'>&laquo;</a></li>";
		echo "	  <li class='disabled'><a href='#'>&lt;</a></li>";
	}
	else
	{
		echo "	  <li><a href='#' onClick='cambiaPaxListado(1)'>&laquo;</a></li>";
		echo "	  <li><a href='#' onClick='cambiaPaxListado(".intval($p -1).")'>&lt;</a></li>";
	}
		
	for($i=1; $i<=$total_paxinas; $i++)
	{
		if($i == $p)
			echo "<li class='active'><a href='#'>".$i."</a></li>";
		else
			echo "<li><a href='#' onClick='cambiaPaxListado(".$i.")'>".$i."</a></li>";
	}
	if($p >= $total_paxinas)
	{
		echo "		  <li class='disabled'><a href='#'>&gt;</a></li>";
		echo "		  <li class='disabled'><a href='#'>&raquo;</a></li>";		
	}
	else
	{
		echo "	  <li><a href='#' onClick='cambiaPaxListado(".intval($p + 1).")'>&gt;</a></li>";
		echo "	  <li><a href='#' onClick='cambiaPaxListado(".intval($total_paxinas).")'>&raquo;</a></li>";		
	}
	echo "		</ul>";
?>
        
       
       
       
       
       
       
      </div>  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>