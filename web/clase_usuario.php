<?php


class usuario
{
	var $nome;
	var $tipo;	
	var $bd;
	
	/*
	 * tipo
	 * 1- administrador/a
	 * 2- moderador/a
	 * 3- usuaria/o
	 */
	
	/*
	 * función __construct
	 * crea un obxecto usuario a partir da súa ID
	 */
	function __construct($id)
	{
		$this->bd = new BD();
		
		$u = $this->bd->usuarioPorID($id);		
		if($u->num_rows > 0)
		{
			while($row = $u->fetch_assoc())
			{
				$this->nome = $row['nome'];
				$this->tipo = $row['tipo'];
			}
		}
	}
	
	/*
	 * destructor da clase usuario
	 */
	function __destruct()
	{}
	
	/*
	 * función admin()
	 * devolve true se o usuario é administrador (tipo 1) do sistema
	 */
	 function admin()
	 {
	 	return ($this->tipo == 1);
	 }
	 
	 /*
	  * función getNome()
	  * devolve o nome do usuario
	  */
	  function getNome()
	  {
	  	return $this->nome;	  	
	  }
	
}

?>