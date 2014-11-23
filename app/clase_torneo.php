<?php

class torneo
{
    private $bd;
    
    private $id;
    
    private $nome;
    private $numero_voltas;
    private $puntos_victoria;
    private $puntos_empate;
    private $puntos_derrota;
    private $iniciado;
        
    private $existe;
    
    /*
     * función __construct
     * crea un obxecto torneo a partir da súa ID
     */
    function __construct($i)
    {
        $this->bd = new BD();
        
        $this->id = $i;    
        
        $mi = mysqli_real_escape_string($this->bd->conexion, $i);
        $sql = "select * from Torneo where ID = '".$mi."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
        
        if($u->num_rows > 0)
        {
            while($row = $u->fetch_assoc())
            {
                $this->nome = $row['nome'];
                $this->numero_voltas = $row['numero_voltas'];
                $this->puntos_victoria = $row['puntos_victoria'];
                $this->puntos_empate = $row['puntos_empate'];
                $this->puntos_derrota= $row['puntos_derrota'];
                $this->iniciado = $row['iniciado'];
                
                $this->existe = true;
            }
        }
        else
        {
            $this->existe = false;
            
        }
    }
    
    /*
     * destructor da clase torneo
     */
    function __destruct()
    {}
    
    /*
     * función existe()
     * devolve true en caso de que o torneo exista na BD 
     */
     function existe()
     {
         return $this->existe;
     }
}