<?php include("header.php"); ?>

<?php
	$accion = $_POST['accion'];	
	
	if ($accion=="rexistro")
	{
		$bd = new BD();		
		if($resultado= $bd->rexistro($_POST['inputLoginRexistro'], $_POST['inputContrasinalRexistro'], $_POST['inputNomeRexistro']))
			echo '
				<div class="container">
				<div class="alert alert-success" role="alert">Noraboa! Rexistr&aacute;cheste correctamente.</div>
				<ul class="pager">
  					<li><a href="index.php">Voltar ao Index</a></li>
				</ul>
				</div>
			';
		else
			echo '
				<div class="container">
				<div class="alert alert-danger" role="alert">Algo foi mal durante o rexistro.</div>
				<ul class="pager">
  					<li><a href="index.php">Voltar ao Index</a></li>
				</ul>
				</div>
			';
	}

	if ($accion=="login")
	{
		$bd = new BD();
		$resultado = $bd->login($_POST['inputLogin'], $_POST['inputContrasinal']);
		
		if($resultado->num_rows > 0)
		{
			while($row = $resultado->fetch_assoc())
			{
				$_SESSION['login'] = $row['ID'];
			}
			header("location:index.php");
		}
		else
			echo '
				<div class="container">
				<div class="alert alert-danger" role="alert">Usuario ou contrasinal incorrecto.</div>
				<ul class="pager">
  					<li><a href="index.php">Voltar ao Index</a></li>
				</ul>
				</div>
			';
	}
?>

<?php include("footer.php"); ?>