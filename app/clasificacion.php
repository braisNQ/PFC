<?php
        echo "<span>Propietario: ".$torneo->getNomePropietario()."</span>";
        echo "<br />";
        echo "<span>N&uacute;mero de membros: ".$torneo->getNumMembros()."</span>";
        
        echo "
            <table class='table table-striped table-hover'>
                <tr>
                    <th>Login</th>
                    <th>Nome</th>
                    <th>&nbsp;</th>
                </tr>
        ";

        $lista = $torneo->listaMembros();
        if($lista->num_rows > 0)
        {
            while($row = $lista->fetch_assoc())
            {
                echo "<tr>";
                    echo "<td>".$row['login']."</td>";
                    echo "<td>".$row['nome']."</td>";           
                    
                    echo "<td>";
                        if(isset($_SESSION['ID']))
                        {
                            if($row['id'] != $_SESSION['ID'])
                                echo "<a class='btn btn-default btn-xs' href='mensaxes.php?id=".$row['id']."'><span class='glyphicon glyphicon-envelope' data-toggle='tooltip' data-placement='top' title='Enviar mensaxe'></span></a> ";
                            if((($row['id'] != $_SESSION['ID']) && ($_SESSION['ID'] == $torneo->getIDPropietario())) || $usuarioActual->admin())
                                echo "<a class='btn btn-danger btn-xs' href='torneo_remove.php?id=".$id."&usuario=".$row['id']."'><span class='glyphicon glyphicon-remove-sign' data-toggle='tooltip' data-placement='top' title='Expulsar usuario'></span></a> ";
                        }
                        
                    echo "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";

        if(isset($_SESSION['ID']))
        {
            //se o usuario actual non ten torneo
            //unirse
            if(!$usuarioActual->getIDequipo())
            {
                echo '
                    <div class="col-sm-2">            
                        <a href="equipo_join.php?id='.$id.'" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Unirme ao equipo</a>
                    </div>
                ';
            }

            //se o usuario actual é membro do equipo e non é o propietario
            //sair
            if(($_SESSION['ID'] != $equipo->getIDPropietario()) && ($usuarioActual->getIDequipo() == $id))
            {
                echo'
                    <div class="col-sm-2">
                        <a href="equipo_leave.php?id='.$id.'" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Sa&iacute;r do equipo</a>
                    </div>
                ';
            }

            //se o usuario actual é admin ou o propietario
            //eliminar
            if(($_SESSION['ID'] == $equipo->getIDPropietario()) || $usuarioActual->admin())
            {
                echo'
                    <div class="col-sm-2">
                        <a href="equipo_delete.php?id='.$id.'" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar equipo</a>
                    </div>
                ';
            }
        }


?>