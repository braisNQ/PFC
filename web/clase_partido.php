<?php


class partido
{
	private $bd;
	
	/*
	 * función __construct
	 * crea un obxecto partido a partir da súa ID
	 */
	function __construct($i)
	{
		$this->bd = new BD();
		
		$this->id = $i;
	}
	
	/*
	 * destructor da clase partido
	 */
	function __destruct()
	{}
	
	/*
	 * función existe()
	 * devolve true en caso de que o partido exista na BD 
	 */
	 function existe()
	 {
	 	return $this->existe;
	 }
}