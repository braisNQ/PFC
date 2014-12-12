<?php


class mensaxe
{
    private $bd;

    private $id;
    private $ID_remitente;
    private $ID_destinatario;
    private $visto;
    private $asunto;
    private $texto;

    private $nomeRemitente;

    private $existe;
    
    /*
     * función __construct
     * crea un obxecto partido a partir da súa ID
     */
    function __construct($i)
    {
        $this->bd = new BD();
        
        $this->id = $i;

        $mi = mysqli_real_escape_string($this->bd->conexion, $i);
        $sql = "select ID_remitente, (select Usuario.nome from Usuario where Usuario.ID = Mensaxe.ID_remitente) as remitente, ID_destinatario, visto, data, asunto, texto from Mensaxe where ID = '".$mi."'";

        $u = mysqli_query($this->bd->conexion, $sql);    
        
        if($u->num_rows > 0)
        {
            while($row = $u->fetch_assoc())
            {
                $this->ID_remitente = $row['ID_remitente'];
                $this->ID_destinatario = $row['ID_destinatario'];
                $this->visto = $row['visto'];
                $this->data = $row['data'];
                $this->asunto = $row['asunto'];
                $this->texto = $row['texto'];

                $this->nomeRemitente = $row['remitente'];

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
     * devolve true en caso de que a mensaxe exista na BD 
     */
     function existe()
     {
        return $this->existe;
     }


     /*
     * función setVisto()
     * marca a mensaxe como vista
     */
     function setVisto()
     {
        $sql = "update Mensaxe set visto=1 where ID='".$this->id."'";
        return mysqli_query($this->bd->conexion, $sql);
     }

     function getAsunto()
     {
        return $this->asunto;
     }

     function getTexto()
     {
        return $this->texto;
     }
     function getDestinatario()
     {
        return $this->ID_destinatario;
     }
     function getRemitente()
     {
        return $this->ID_remitente;
     }

     function getNomeRemitente()
     {
        return $this->nomeRemitente;
     }

     function eliminar()
     {        
        $sql = "delete from Mensaxe where ID='".$this->id."'";        
        return (mysqli_query($this->bd->conexion, $sql));
     }

}