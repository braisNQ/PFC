<?php


class equipo
{
    private $bd;
    
    private $id;
    
    private $nome;
    private $ID_propietario;
    private $codigo_ingreso;
    
    private $nomePropietario;    
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
        $sql = "select nome, ID_propietario, codigo_ingreso, (select Usuario.nome from Usuario where Usuario.ID = Equipo.ID_propietario) as nomePropietario from Equipo where ID = '".$mi."'";
        $u = mysqli_query($this->bd->conexion, $sql);    
        
        if($u->num_rows > 0)
        {
            while($row = $u->fetch_assoc())
            {
                $this->nome = $row['nome'];
                $this->ID_propietario = $row['ID_propietario'];
                $this->codigo_ingreso = $row['codigo_ingreso'];
                
                $this->nomePropietario = $row['nomePropietario'];
                
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
        $sql = "update Usuario set ID_equipo = NULL where ID_equipo ='".$this->id."'";
        $toret = mysqli_query($this->bd->conexion, $sql);
        
        $sql = "delete from Equipo where ID='".$this->id."'";        
        return ($toret && mysqli_query($this->bd->conexion, $sql));
     }
     
     /*
      * función listaMembros()
      * devolve a lista de membros do equipo
      */
     function listaMembros()
     {
        $sql = "select id, login, nome from Usuario where ID_equipo ='".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
     }
     
     /*
      * función getNome()
      * devolve o nome do equipo
      */
     function getNome()
     {
         return $this->nome;
     }
     
     /*
      * función getNomePropietario()
      * devolve o nome do propietario
      */
     function getNomePropietario()
     {
         return $this->nomePropietario;
     }

    /*
    * función getIDPropietario()
    * devolve o nome do propietario
    */
     function getIDPropietario()
     {
         return $this->ID_propietario;
     }

    /*
    * función getCodigoIngreso()
    * devolve o nome do propietario
    */
     function getCodigoIngreso()
     {
         return $this->codigo_ingreso;
     }
     
     /*
      * función getNumMembros()
      * devolve o número de membros do equipo
      */
     function getNumMembros()
     {
        $sql = "select * from Usuario where ID_equipo = '".$this->id."'";
        $res = mysqli_query($this->bd->conexion, $sql);
        return $res->num_rows;        
     }

    /*
      * funcion editar($nome, $codigo)
      * edita os datos de nome e codigo do equipo
      */
     function editar($nome, $codigo)
     {
        $n = mysqli_real_escape_string($this->bd->conexion, $nome);    
        $c = mysqli_real_escape_string($this->bd->conexion, $codigo);

        $sql = "update Equipo set nome = '".$n."', codigo_ingreso = '".$c."' where ID = '".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
     }    
     
     
}