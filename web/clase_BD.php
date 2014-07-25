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
	 function updateAdmin()
	 {
	 	
		$sql = "update Usuario set nome='administrador' where ID=1";
		echo $sql;
		mysqli_query($this->conexion,$sql);
	 }
	  * */
	 
}



?>