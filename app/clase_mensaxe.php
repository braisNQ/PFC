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
     * crea un obxecto mensaxe a partir da súa ID
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

     /*
     * función getAsunto()
     * devolve o asunto da mensaxe
     */
     function getAsunto()
     {
        return $this->asunto;
     }

     /*
     * función getTexto()
     * devolve o Texto da mensaxe
     */
     function getTexto()
     {
        return $this->texto;
     }

     /*
     * función getDestinatario()
     * devolve a ID do destinatario
     */
     function getDestinatario()
     {
        return $this->ID_destinatario;
     }

     /*
     * función getRemitente()
     * devolve a ID do remitente
     */
     function getRemitente()
     {
        return $this->ID_remitente;
     }

     /*
     * función getNomeRemitente()
     * devolve o nome do remitente
     */
     function getNomeRemitente()
     {
        return $this->nomeRemitente;
     }

     /*
     * función eliminar()
     * elimina a mensaxe da BD
     */
     function eliminar()
     {        
        $sql = "delete from Mensaxe where ID='".$this->id."'";        
        return (mysqli_query($this->bd->conexion, $sql));
     }
}