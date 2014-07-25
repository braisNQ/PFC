<?php

class BD
{
	var $conexion;	//almacena a conexión coa BD
	
	/*
	 * función __construct
	 * crea a conexión coa BD 
	 */
	function __construct()
	{
		$this->conexion = mysqli_connect("localhost", "userpfc", "userpfc", "pfc");
	}
	
	/*
	 * función __destruct
	 * elimina a conexión coa BD
	 */	
	function __destruct()
	{
		mysqli_close($this->conexion);
	}
	
	/*
	 * función login(ususario, contrasinal)
	 * busca na BD se existe algunha entrada para os parámetros indicados
	 * devolve o usuario solicitado
	 */
	 function login ($usuario, $contrasinal)
	 {
	 	$u = mysqli_real_escape_string($this->conexion, $usuario);
	 	$sql = "select * from Usuario where login = '".$u."' and contrasinal ='".$contrasinal."'";
		return mysqli_query($this->conexion, $sql);
	 }
	 
	 /*
	  * función rexistro ($usuario, $contrasinal, $nome)
	  * inserta na BD un novo usuario
	  * devolve o resultado de executar a consulta
	  */
	 function rexistro ($usuario, $contrasinal, $nome)
	 {
	 	$u = mysqli_real_escape_string($this->conexion, $usuario);
		$n = mysqli_real_escape_string($this->conexion, $nome);
	 	$sql = "select * from Usuario where login = '".$u."' and contrasinal ='".$contrasinal."'";
		$sql = "insert into Usuario (login, contrasinal, nome, tipo) values ('".$u."', '".$contrasinal."', '".$n."', 3)";
		return mysqli_query($this->conexion, $sql);
	 }
	 
	 /*
	  * función buscaLogin($login)
	  * busca un login concreto na BD
	  */
	 function buscaLogin($login)
	 {
	 	$l = mysqli_real_escape_string($this->conexion, $login);
	 	$sql = "select * from Usuario where login = '".$l."'";
		return mysqli_query($this->conexion, $sql);	 	
	 }
	 
	 /*
	  * función usuarioPorID($id)
	  * devolve o usuario solicitado
	  */
	 function usuarioPorID($id)
	 {
	 	$i = mysqli_real_escape_string($this->conexion, $id);
	 	$sql = "select * from Usuario where ID = '".$i."'";
		return mysqli_query($this->conexion, $sql);	
	 }
	 
	 /*
	  * función numeroUsuarios()
	  * devolve o número de usuarios creados na aplicación sen contar a "administrador"
	  */
	  function numeroUsuarios()
	  {
	  	$sql = "select * from Usuario where ID > 1";
		$res = mysqli_query($this->conexion, $sql);
		return $res->num_rows;		
	  }
	  
	  /*
	   * función listarUsuarios
	   * devolve a lista de usuarios que cumplen un filtro específico
	   */
	  function listarUsuarios($items, $login, $nome, $nomeequipo, $enequipo, $tipo, $orderby, $order, $inicio)
	  {
	  	$l = mysqli_real_escape_string($this->conexion, $login);
		$n = mysqli_real_escape_string($this->conexion, $nome);
		$ne = mysqli_real_escape_string($this->conexion, $nomeequipo);
		
		$sql='';
		$sql = $sql."select ID, login, nome, tipo, ID_equipo, ";
		$sql = $sql."(select Equipo.nome from Equipo where Equipo.ID = Usuario.ID_equipo and Equipo.nome like '%".$ne."%') as nomeequipo ";
		$sql = $sql." from Usuario where ";
		$sql = $sql."ID > 1 ";
		$sql = $sql."and nome like '%".$n."%' ";
		$sql = $sql."and login like '%".$l."%' ";
		
		if($enequipo == "on")
			$sql = $sql."and ID_equipo is not NULL ";
		
		if($tipo > 0)
			$sql = $sql."and tipo =".$tipo." ";
					
		$sql = $sql."order by ".$orderby." ".$order." ";		
		$sql = $sql."limit " . $inicio . "," . $items." " ;
		
		return mysqli_query($this->conexion, $sql);	  	
	  }
	  
	  /*
	   * función listarUsuariosCont
	   * devolve o número de usuarios que cumplen un filtro específico
	   */
	  function listarUsuariosCont($login, $nome, $nomeequipo, $enequipo, $tipo)
	  {
	  	$l = mysqli_real_escape_string($this->conexion, $login);
		$n = mysqli_real_escape_string($this->conexion, $nome);
		$ne = mysqli_real_escape_string($this->conexion, $nomeequipo);
		
		$sql='';
		$sql = $sql."select ID, login, nome, tipo, ID_equipo, ";
		$sql = $sql."(select Equipo.nome from Equipo where Equipo.ID = Usuario.ID_equipo and Equipo.nome like '%".$ne."%') as nomeequipo ";
		$sql = $sql." from Usuario where ";
		$sql = $sql."ID > 1 ";
		$sql = $sql."and nome like '%".$n."%' ";
		$sql = $sql."and login like '%".$l."%' ";
		
		if($enequipo == "on")
			$sql = $sql."and ID_equipo is not NULL ";
		
		if($tipo > 0)
			$sql = $sql."and tipo =".$tipo." ";
		
		return mysqli_query($this->conexion, $sql)->num_rows;	  	
	  }
	 
	 /*
	 function updateAdmin()
	 {
	 	
		$sql = "update Usuario set nome='administrador' where ID=1";
		echo $sql;
		mysqli_query($this->conexion,$sql);
	 }
	  * */
	 
}



?>