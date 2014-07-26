<?php


class equipo
{
	private $bd;
	
	private $id;
	
	private $nome;
	private $ID_propietario;
	private $codigo_ingreso;
	
	private $existe;
	
	/*
	 * tipo
	 * 1- administrador/a
	 * 2- moderador/a
	 * 3- usuaria/o
	 */
	
	/*
	 * función __construct
	 * crea un obxecto equipo a partir da súa ID
	 */
	function __construct($i)
	{
		$this->bd = new BD();
		
		$this->id = $i;	
		
	 	$mi = mysqli_real_escape_string($this->bd->conexion, $i);
	 	$sql = "select * from Equipo where ID = '".$mi."'";
		$u = mysqli_query($this->bd->conexion, $sql);	
		
		if($u->num_rows > 0)
		{
			while($row = $u->fetch_assoc())
			{
				$this->nome = $row['nome'];
				$this->ID_propietario = $row['ID_propietario'];
				$this->codigo_ingreso = $row['codigo_ingreso'];
				$this->tipo = $row['tipo'];
				
				$this->existe = true;
			}
		}
		else
		{
			$this->existe = false;
			
		}
	}
	
	/*
	 * destructor da clase equipo
	 */
	function __destruct()
	{}
	
	/*
	 * función existe()
	 * devolve true en caso de que o equipo exista na BD 
	 */
	 function existe()
	 {
	 	return $this->existe;
	 }
	 
	 /*
	  * función eliminar()
	  * elimina un equipo da BD 
	 */
	 function eliminar()
	 {
	 	$sql = "delete from Equipo where ID='".$this->id."'";		
		return mysqli_query($this->bd->conexion, $sql);
	 }
	 
	 /*
	  * función listaMembros()
	  * devolve a lista de membros do equipo
	  */
	 function listaMembros()
	 {
	 	$sql = "select id, login, nome from Usuario where ID_equipo ='".$this->id."'";
	 }
	 
	 
	 
}