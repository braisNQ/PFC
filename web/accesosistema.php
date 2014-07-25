<?php include("header.php"); ?>

<?php
	
	//se non existe unha variable de sesión
		//realiza as accións de rexistro e login
	//else
		//aviso de xa ter unha sesión iniciada

	if (!isset($_SESSION['ID']))
	{
		$accion = $_POST['accion'];	
		
		if ($accion=="rexistro")
		{
			$bd = new BD();
			
			//busca o login introducido na BD
			//se non existe
				//inserta o usuario
				//se non hai fallos
					//crea sesión para o usuario
					//aviso de rexistro correcto
				//else
					//aviso erro no rexistro
			//else
				//aviso de login xa existente
			
			if($bd->buscaLogin($_POST['inputLoginRexistro'])->num_rows == 0)
			{
				if($resultado = $bd->rexistro($_POST['inputLoginRexistro'], $_POST['inputContrasinalRexistro'], $_POST['inputNomeRexistro']))
				{
					$resultado = $bd->login($_POST['inputLoginRexistro'], $_POST['inputContrasinalRexistro']);		
					if($resultado->num_rows > 0)
					{
						while($row = $resultado->fetch_assoc())
						{
							$_SESSION['ID'] = $row['ID'];
						}
					}
					aviso("success", "Noraboa ".$_POST['inputNomeRexistro']."! Rexistr&aacute;cheste correctamente.");
				}
				else
					aviso("danger", "Algo foi mal durante o rexistro.");
			}
			else
				aviso("danger", "O login que elixiches xa está en uso.");		
		}
	
		if ($accion=="login")
		{
			$bd = new BD();
			$resultado = $bd->login($_POST['inputLogin'], $_POST['inputContrasinal']);
			
			if($resultado->num_rows > 0)
			{
				while($row = $resultado->fetch_assoc())
				{
					$_SESSION['ID'] = $row['ID'];
				}
				header("location:index.php");
			}
			else
				aviso("danger", "Usuario ou contrasinal incorrecto.");
	
		}
	}
	else
		aviso("danger", "Xa hai unha sesión aberta no navegador.");
	
?>

<?php
	function aviso($color, $msg)
	{
		echo '
			<div class="container">
			<div class="alert alert-'.$color.'" role="alert">'.$msg.'</div>
			<ul class="pager">
				<li><a href="index.php">Voltar ao Index</a></li>
			</ul>
			</div>
		';
		
	}
?>


<?php include("footer.php"); ?>