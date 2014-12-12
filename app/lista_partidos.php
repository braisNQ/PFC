<?php     

    $lista = $torneo->listaPartidos();
    
    echo "
        <table class='table table-striped table-hover'>
            <tr>
                <th>Enfrentamento</th>
                <th>Resultado</th>
                <th>Data</th>
                <th>&nbsp;</th>
            </tr>
    ";

    if($lista->num_rows > 0)
    {
        while($row = $lista->fetch_assoc())
        {
            echo "<tr>";
                echo "<td><a href='partido.php?id=".$row['ID']."'><b>".$row['nome1']."</b> vs <b>".$row['nome2']."</b></a></td>";    
                echo "<td>".$row['resultado_eq1'].":".$row['resultado_eq2'];
                if($row['resultado_confirmado']==0)
                    echo "*";
                echo "</td>";
                echo "<td>".$row['data'];
                if($row['data_confirmada']==0)
                    echo "*";
                echo "</td>";  
                echo "<td>";

                if(isset($_SESSION['ID']))
                {
                    //if($row['resultado_confirmado']==1)
                   // {
                        if($usuarioActual->modTorneo($row['ID']) || $usuarioActual->admin())
                        {
                            echo "<a class='btn btn-info btn-xs' href='partido.php?id=".$row['ID']."&tab=editar'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Editar resultado'></span></a> ";
                        }

                   // }
                    /*
                    if($usuarioActual->capitan() && ($usuarioActual->getIDequipo() == $row['ID_equipo1'] || $usuarioActual->getIDequipo() == $row['ID_equipo2']))
                    {
                        if($row['data_confirmada']==1)
                        {
                            echo "<a class='btn btn-info btn-xs' href='partido.php?id=".$row['ID']."&tab=rematar'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Finalizar partido'></span></a> ";
                        }
                        else
                        {
                            echo "<a class='btn btn-info btn-xs' href='partido.php?id=".$row['ID']."&tab=configurar'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Configurar partido'></span></a> ";
                        }

                    }
                    */
                }
                    
                echo "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
?>
        