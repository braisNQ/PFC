<?php


class partido
{
    private $bd;
    private $existe;

    private $ID_torneo;
    private $ID_equipo1;
    private $ID_equipo2;
    private $data;
    private $data_modificado;
    private $data_confirmada;
    private $resultado_eq1;
    private $resultado_eq2;
    private $resultado_modificado;
    private $resultado_confirmado;

    private $nome1;
    private $nome2;
    
    /*
     * función __construct
     * crea un obxecto partido a partir da súa ID
     */
    function __construct($i)
    {
        $this->bd = new BD();
        
        $this->id = $i;    
        
        $mi = mysqli_real_escape_string($this->bd->conexion, $i);
        
        //$sql = "select * from Partido where ID = '".$mi."'";
        $sql = "select ID_torneo, ID_equipo1, (select nome from Equipo where Equipo.ID = Partido.ID_equipo1) as nome1, ID_equipo2, (select nome from Equipo where Equipo.ID = Partido.ID_equipo2) as nome2, data, data_confirmada, data_modificado, resultado_modificado, resultado_eq1, resultado_eq2, resultado_confirmado from Partido where ID ='".$mi."'";
        
       
        $p = mysqli_query($this->bd->conexion, $sql);    
        
        if($p->num_rows > 0)
        {
            while($row = $p->fetch_assoc())
            {
                $this->ID_torneo = $row['ID_torneo'];
                $this->ID_equipo1 = $row['ID_equipo1'];
                $this->ID_equipo2 = $row['ID_equipo2'];
                $this->data = $row['data'];
                $this->data_modificado = $row['data_modificado'];
                $this->data_confirmada = $row['data_confirmada'];
                $this->resultado_eq1 = $row['resultado_eq1'];
                $this->resultado_eq2 = $row['resultado_eq2'];
                $this->resultado_modificado = $row['resultado_modificado'];
                $this->resultado_confirmado = $row['resultado_confirmado'];

                $this->nome1 = $row['nome1'];
                $this->nome2 = $row['nome2'];

                $this->existe = true;
            }
        }
        else
        {
            $this->existe = false;
            
        }
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

     /*
     * fuinción getIDtorneo()
     * devolve a id do torneo
     */
     function getIDtorneo()
     {
        return $this->ID_torneo;
     }

     /*
     * fuinción editar($r1, $r2)
     * Actualiza o resultado do partido
     */
     function editar($r1, $r2)
     {
        $data=date('Y-m-d H:i:s');
        $sql = "update Partido set resultado_confirmado=1, resultado_eq1=".$r1.", resultado_eq2=".$r2.", data='".$data."', data_confirmada=1 where ID='".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql); 
     }

     /*
     * fuinción resultado1()
     * devolve o resultado do equipo 1
     */
     function resultado1()
     {
        return $this->resultado_eq1;
     }

     /*
     * fuinción resultado2()
     * devolve o resultado do equipo 2
     */
     function resultado2()
     {
        return $this->resultado_eq2;
     }

     /*
     * fuinción getNomeEQ1()
     * devolve o nome do equipo 1
     */
     function getNomeEQ1()
     {
        return $this->nome1;
     }

     /*
     * fuinción getNomeEQ2()
     * devolve o nome do equipo 2
     */
     function getNomeEQ2()
     {
        return $this->nome2;
     }

     /*
     * fuinción getData()
     * devolve a data do partido
     */
     function getData()
     {
        return $this->data;
     }
}