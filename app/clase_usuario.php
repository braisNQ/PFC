<?php


class usuario
{
    private $bd;
    
    private $id;
    
    private $login;
    private $contrasinal;
    private $nome;
    private $tipo;    
    private $ID_equipo;
    
    private $existe;
    
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
    function __construct($i)
    {
        $this->bd = new BD();
        
        $this->id = $i;    
        
        $mi = mysqli_real_escape_string($this->bd->conexion, $i);
        $sql = "select * from Usuario where ID = '".$mi."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
        
        if($u->num_rows > 0)
        {
            while($row = $u->fetch_assoc())
            {
                $this->login = $row['login'];
                $this->contrasinal = $row['contrasinal'];
                $this->nome = $row['nome'];
                $this->tipo = $row['tipo'];
                $this->ID_equipo = $row['ID_equipo'];
                $this->existe = true;
            }
        }
        else
        {
            $this->existe = false;
            
        }
    }
    
    /*
     * destructor da clase usuario
     */
    function __destruct()
    {}
    
    /*
     * función existe()
     * devolve true en caso de que o usuario exista na BD 
     */
     function existe()
     {
         return $this->existe;
     }
    
    /*
     * función admin()
     * devolve true se o usuario é administrador (tipo 1) do sistema
     */
     function admin()
     {
         return ($this->tipo == 1);
     } 
     
     /*
      * función getLogin()
      * devolve o Login do usuario
      */
      function getLogin()
      {
          return $this->login;          
      }
      
     /*
      * función getContrasinal()
      * devolve o contrasinal do usuario
      */
      function getContrasinal()
      {
          return $this->contrasinal;          
      }      
      
     /*
      * función getNome()
      * devolve o nome do usuario
      */
      function getNome()
      {
          return $this->nome;          
      }
            
     /*
      * función getTipo()
      * devolve o tipo do usuario
      */
      function getTipo()
      {
          return $this->tipo;          
      }
      
     /*
      * función getIDequipo()
      * devolve o ID do equipo do usuario
      */
      function getIDequipo()
      {
          return $this->ID_equipo;          
      }
      
     /*
      * función getNomeEquipo()
      * devolve o nome do usuario
      */
      function getNomeEquipo()
      {          
         $sql = "select nome from Equipo where ID = '".$this->ID_equipo."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
        
        $toret='';
        
        if($u->num_rows > 0)
        {
            while($row = $u->fetch_assoc())
            {
                $toret = $row['nome'];
                
            }
        }
        
        return $toret;
      }
      
      /*
       * función mensaxesNovas()
       * devolve o número de mensaxes sen ler do usuario
       */
        function mensaxesNovas()
        {
            $sql = "select * from Mensaxe where ID_destinatario = '".$this->id."' and visto = 0";
            $u = mysqli_query($this->bd->conexion, $sql);    
                
            $toret= 0;
                
            if($u->num_rows > 0)
            {
                $toret = $u->num_rows;
            }
            
            return $toret;
        }
      
      /*
       * función numMensaxes()
       * devolve o número de mensaxes do usuario
       */
        function numMensaxes()
        {
            $sql = "select * from Mensaxe where ID_destinatario = '".$this->id."'";
            $u = mysqli_query($this->bd->conexion, $sql);    
                
            $toret= 0;
                
            if($u->num_rows > 0)
            {
                $toret = $u->num_rows;
            }
            
            return $toret;
        }
      
      /*
       * función listarMensaxesCont($f)
       * devolve o numero de mensaxes do usuario que correspondan a un filtro
       */
        function listarMensaxesCont($f)
        {
            $sql = "select * from Mensaxe where ID_destinatario = '".$this->id."'";

            if($f == "novas")
                $sql = $sql." and visto = 0";
            if($f == "vistas")
                $sql = $sql." and visto = 1";

            $u = mysqli_query($this->bd->conexion, $sql);    
                
            $toret= 0;
                
            if($u->num_rows > 0)
            {
                $toret = $u->num_rows;
            }
            
            return $toret;
        }

    /*
   * función listarMensaxes($f)
   * devolve as mensaxes do usuario que correspondan a un filtro
   */
    function listarMensaxes($f, $inicio, $items)
    {
        $sql = "select ID, ID_remitente, (select nome from Usuario where Usuario.ID = Mensaxe.ID_remitente) as remitente, asunto, visto, data from Mensaxe where ID_destinatario = '".$this->id."'";

        if($f == "novas")
            $sql = $sql." and visto = 0";
        if($f == "vistas")
            $sql = $sql." and visto = 1";
                 
        $sql = $sql." limit " . $inicio . "," . $items." " ;
        
        return mysqli_query($this->bd->conexion, $sql); 
    }
    
    /*
     * función modTorneo($idtorneo)
     * devolve true se o usuario é moderador do torneo indicado
     */
     function modTorneo($idtorneo)
     {
        $sql = "select * from TorneoModerador where ID_moderador = '".$this->id."' and ID_torneo = '".$idtorneo."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
            
        $toret= false;
            
        if($u->num_rows > 0)
        {
            $toret = true;
        }
        
        return $toret;
     }
     
     /*
      * funcion editar($nome, $contrasinal)
      * edita os datos de nome e contrasinal do usuario
      */
     function editar($nome, $contrasinal)
     {
        $n = mysqli_real_escape_string($this->bd->conexion, $nome);
        $sql = "update Usuario set nome = '".$n."', contrasinal = '".$contrasinal."' where ID = '".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
     }
    
    /*
     * función darAdmin()
     * actualiza o usuario para darlle nivel de administrador
     */
    function darAdmin()
    {
        $sql = "update Usuario set tipo = 1 where ID = '".$this->id."'";
        $this->tipo = 1;
        return mysqli_query($this->bd->conexion, $sql);
    }
    
    /*
     * función quitarAdmin()
     * actualiza o usuario para quitarlle nivel de administrador
     */
    function quitarAdmin()
    {
        $nivel = 3;
        
        $sql = "select * from TorneoModerador where ID_moderador = '".$this->id."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
            
        if($u->num_rows > 0)
            $nivel = 2;
        
        $sql = "update Usuario set tipo = '".$nivel."' where ID = '".$this->id."'";
        
        $this->tipo = $nivel;
        return mysqli_query($this->bd->conexion, $sql);
    }

    /*
     * función darMod($id)
     * actualiza o usuario para darlle nivel de moderador
     */
    function darMod($id)
    {
        if($this->tipo != 1)
        {
            $sql = "update Usuario set tipo = 2 where ID = '".$this->id."'";
        }
        $this->tipo = 2;
        $toret = mysqli_query($this->bd->conexion, $sql);

        $sql = "insert into TorneoModerador (ID_torneo, ID_moderador) values ('".$id."', '".$this->id."')";


        return ($toret && mysqli_query($this->bd->conexion, $sql));
    }

    /*
     * función quitarMod($id)
     * quitar permisos de moderación nun torneo
     */
    function quitarMod($id)
    {
        $sql = "delete from TorneoModerador where ID_torneo='".$id."' and ID_moderador = '".$this->id."'";
        $toret = mysqli_query($this->bd->conexion, $sql);

        $nivel = 3;

        $sql = "select * from TorneoModerador where ID_moderador = '".$this->id."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
        
        if($u->num_rows > 0)
            $nivel = 2;

        if($this->tipo != 1)
        {
           $sql = "update Usuario set tipo = '".$nivel."' where ID = '".$this->id."'";
        }
        $this->tipo = $nivel;
        
        return ($toret && mysqli_query($this->bd->conexion, $sql));
    }
    
    /*
     * función eliminar()
     * elimina o usuario do sistema
     */
    function eliminar()
    {
        $sql = "update Usuario set ID_equipo = NULL where ID_equipo ='".$this->ID_equipo."'";
        $toret = mysqli_query($this->bd->conexion, $sql);
        
        $sql = "delete from Equipo where ID='".$this->ID_equipo."'";        
        $toret = ($toret && mysqli_query($this->bd->conexion, $sql));

        $sql = "delete from Usuario where ID='".$this->id."'";        
        return ($toret && mysqli_query($this->bd->conexion, $sql));
    }
    
    /*
     * functión entrarEquipoCreado()
     * actualiza o usuario para indicarlle a ID do equipo que acaba de crear 
    */
    function entrarEquipoCreado()
    {
        $ide;
        $sql = "select ID from Equipo where ID_propietario ='".$this->id."'";
        $u = mysqli_query($this->bd->conexion, $sql);
        if($u->num_rows > 0)
        {
            while($row = $u->fetch_assoc())
            {
                $ide = $row['ID'];
                $this->ID_equipo = $ide;
            }
        }
        
        $sql = "update Usuario set ID_equipo = '".$ide."' where ID = '".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);    
    }
    
    /*
     * función entrarEquipo($i)
     * actualiza o usuario para indicarlle a nova ID de equipo
     */
    function entrarEquipo($i)
    {
        $this->ID_equipo = $i;
        $sql = "update Usuario set ID_equipo = '".$i."' where ID = '".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
    }
    
    /*
     * función sairEquipo()
     * actualiza o usuario para indicarlle a nova ID de equipo
     */
    function sairEquipo()
    {
        $sql = "update Usuario set ID_equipo = NULL where ID = '".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);        
    }

    /*
     * función capitan()
     * devolve true se o usuario é capitán dun equipo
     */
     function capitan()
     {
        $sql = "select * from Equipo where ID_propietario ='".$this->id."'";
        $u = mysqli_query($this->bd->conexion, $sql);
        return ($u->num_rows > 0);
     }

     /*
     * función enTorneo($i)
     * devolve true se o equipo do usuario está no torneo
     */
     function enTorneo($i)
     {
        $toret = false;
        $sql = "select * from EquipoTorneo where ID_equipo ='".$this->ID_equipo."' and ID_torneo ='".$i."'";
        $u = mysqli_query($this->bd->conexion, $sql);
        if($u->num_rows > 0)
            $toret = true;
        return $toret;
     }

     /*
      * función enviarMensaxe($id, $asunto, $txt, $data)
      * inserta na BD unha nova mensaxe
      * devolve o resultado de executar a consulta
      */
     function enviarMensaxe($id, $asunto, $txt, $data)
     {
        $a = mysqli_real_escape_string($this->bd->conexion, $asunto);
        $t = mysqli_real_escape_string($this->bd->conexion, $txt);      
        
        $sql = "insert into Mensaxe (ID_remitente, ID_destinatario, data, asunto, texto, visto) values ('".$this->id."', '".$id."', '".$data."', '".$a."', '".$t."', 0)";

        return mysqli_query($this->bd->conexion, $sql);
     }
}

?>