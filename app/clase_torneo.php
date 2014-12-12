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

      /*
      * función getNome()
      * devolve o nome do torneo
      */
     function getNome()
     {
         return $this->nome;
     }

    /*
      * función getNumVoltas()
      * devolve o número de voltas
      */
     function getNumVoltas()
     {
         return $this->numero_voltas;
     }

     /*
      * función getPuntosVictoria()
      * devolve o número de puntos por victoria
      */
     function getPuntosVictoria()
     {
         return $this->puntos_victoria;
     }

     /*
      * función getPuntosEmpate()
      * devolve o número de puntos por empate
      */
     function getPuntosEmpate()
     {
         return $this->puntos_empate;
     }

     /*
      * función getPuntosDerrota()
      * devolve o número de puntos por derrota
      */
     function getPuntosDerrota()
     {
         return $this->puntos_derrota;
     }

     /*
      * función iniciado()
      * devolve true se o torneo está iniciado
      */
     function iniciado()
     {
        $toret = false;
        if($this->iniciado == 1)
            $toret = true;
        return $toret;
     }

     /*
      * función eliminar()
      * elimina un torneo da BD 
     */
     function eliminar()
     {        
        $sql = "delete from Torneo where ID='".$this->id."'";       
        return (mysqli_query($this->bd->conexion, $sql));        
     }

    /*
      * funcion editar($nome, $voltas, $p_victoria, $p_empate, $p_derrota)
      * edita as preferencias dun torneo
      */
     function editar($nome, $voltas, $p_victoria, $p_empate, $p_derrota)
     {
        $n = mysqli_real_escape_string($this->bd->conexion, $nome);

        $sql = "update Torneo set nome = '".$n."', numero_voltas = '".$voltas."', puntos_victoria = '".$p_victoria."', puntos_empate = '".$p_empate."', puntos_derrota = '".$p_derrota."' where ID = '".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
     }

     /*
     * función agregarEquipo($i)
     * Inscribe un equipo no torneo
     */
     function agregarEquipo($i)
     {  
        $sql = "insert into EquipoTorneo (ID_torneo, ID_equipo) values ('".$this->id."', '".$i."')";
        return mysqli_query($this->bd->conexion, $sql);
     }

    /*
    * función listaEquipos
    * devolve a lista de ids de equipos apuntados ao torneo
    */
    function listaEquipos()
    {
        $sql = "select ID_equipo, (select nome from Equipo where Equipo.ID=EquipoTorneo.ID_equipo) as nome from EquipoTorneo where ID_torneo ='".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);          
    }

    function getVoltas()
    {
        return $this->numero_voltas;
    }

    function iniciar()
    {
        $sql = "update Torneo set iniciado=1 where ID='".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
    }

    function crearPartido($e1, $e2)
    {
        $sql = "insert into Partido (ID_equipo1, ID_equipo2, ID_torneo) values ('".$e1."', '".$e2."', '".$this->id."')";
        return mysqli_query($this->bd->conexion, $sql);
    }

    function listaPartidos()
    {
        $sql = "select ID, ID_equipo1, (select nome from Equipo where Equipo.ID = Partido.ID_equipo1) as nome1, ID_equipo2, (select nome from Equipo where Equipo.ID = Partido.ID_equipo2) as nome2, data, data_confirmada, resultado_eq1, resultado_eq2, resultado_confirmado from Partido where ID_torneo ='".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);  
    }

    function listaMods()
    {
        $sql = "select ID, nome from Usuario where ID in (select ID_moderador from TorneoModerador where ID_torneo=".$this->id.")";
        return mysqli_query($this->bd->conexion, $sql);  
    }

    function partidosEquipo($id)
    {
        $sql = "select ID_equipo1, ID_equipo2, resultado_eq1, resultado_eq2 from Partido where ID_torneo ='".$this->id."' and (ID_equipo1 ='".$id."' or ID_equipo2 ='".$id."') and resultado_confirmado=1";
        return mysqli_query($this->bd->conexion, $sql);
    }







}