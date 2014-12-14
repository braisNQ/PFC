<?php include("header.php"); ?>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">PFC</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="lista_usuarios.php">Usuarios</a></li>
            <li class="active"><a href="lista_equipos.php">Equipos</a></li>
            <li><a href="lista_torneos.php">Torneos</a></li>            
          </ul>
          
          <ul class="nav navbar-nav navbar-right">              
              <?php include("login.php"); ?>
              
<!-- /ul /div /div /div dentro de login.php
          </ul>
        </div><!--/.nav-collapse -->
<!--
      </div>
    </div>
    -->

    <div class="container">
        <div class="jumbotron">
<?php
                
    //se non existe ID
    if(!isset($_GET['id']) && !isset($_POST['id']))
    {
        //se está logueado e non ten equipo
        //invita a crear
        if(isset($_SESSION['ID']) && !$usuarioActual->getIDequipo())
        {
            echo '
                <div class="container">
                    <div class="alert alert-info" role="alert">
                        Parece que non pertences a ning&uacute;n equipo....
                        <ul class="pager">
                            <li><a href="lista_equipos.php">Buscar equipo</a></li>
                            <li><a href="equipo_create.php">Crear equipo</a></li>
                        </ul>
                    </div>
                </div>
            ';
        }
        //se non está logueado
        //lanza aviso
        else
        {
            aviso("danger", "Produciuse un erro.", "lista_equipos.php", "Voltar &aacute; lista");
        }
    }
    //coñece id
    else
    {
        $id;
        if(isset($_GET['id']))
            $id= $_GET['id'];
        if(isset($_POST['id']))
            $id= $_POST['id'];
        $equipo = new equipo($id);
        
        $tab;
        if(isset($_GET['tab']))
            $tab =$_GET['tab'];
        else
            $tab = "perfil";

        //se se seleccionou o botón de acción
        if(isset($_POST['accion']) )
        {
            //se seleccionou editar
            if($_POST['accion'] == 'editar')
            {
                if(($_SESSION['ID'] == $equipo->getIDPropietario()) || $usuarioActual->admin())
                {
                    $n = $_POST['nome'];
                    $c = $_POST['codigo'];
                    
                    if($equipo->editar($n, $c))
                        aviso("success", "O equipo <b>".$n."</b> foi actualizado correctamente.", "equipo.php?id=".$id, "Voltar ao perfil");
                    else
                        aviso("danger", "Houbo alg&uacute;n problema durante a modificaci&oacute;n do equipo", "equipo.php?id=".$id."&tab=editar", "Voltar ao perfil");
                }
                else
                {
                    aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o equipo solicitado.", "equipo.php?id=".$id, "Voltar ao perfil");
                }
            }
            else
            {
                aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o equipo solicitado.", "equipo.php?id=".$id, "Voltar ao perfil");
            }
        }
        //se carga a páxina sen pulsar ningún botón
        //presenta o formulario por defecto
        else
        {
            
        ?>
        
        <fieldset>
            <legend><?php echo $equipo->getNome();?></legend>
    
            <ul class="nav nav-tabs" role="tablist">
                <li <?php if($tab=="perfil") echo 'class="active"'; ?>><a href="equipo.php?id=<?php echo $id; ?>&tab=perfil">Perfil</a></li>
                <li <?php if($tab=="torneos") echo 'class="active"'; ?>><a href="equipo.php?id=<?php echo $id; ?>&tab=torneos">Torneos</a></li>
                <?php
                    if(isset($_SESSION['ID']))
                    {
                        if(($_SESSION['ID'] == $equipo->getIDPropietario()) || $usuarioActual->admin())
                        {
                            echo '<li ';
                            if($tab=="editar")
                                echo 'class="active"';
                            echo '><a href="equipo.php?id='.$id.'&tab=editar">Editar</a></li>';
                        }
                    }
                ?>
            </ul>
            
            <br />
    
<?php
    if($tab == "perfil")
    {
        echo "<span>Propietario: ".$equipo->getNomePropietario()."</span>";
        echo "<br />";
        echo "<span>N&uacute;mero de membros: ".$equipo->getNumMembros()."</span>";
        
        echo "
            <table class='table table-striped table-hover'>
                <tr>
                    <th>Login</th>
                    <th>Nome</th>
                    <th>&nbsp;</th>
                </tr>
        ";

        $lista = $equipo->listaMembros();
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
                            if($row['id'] != $equipo->getIDPropietario())
                            {
                                if($row['id'] != $_SESSION['ID'])
                                    echo "<a class='btn btn-default btn-xs' href='mensaxes.php?id=".$row['id']."'><span class='glyphicon glyphicon-envelope' data-toggle='tooltip' data-placement='top' title='Enviar mensaxe'></span></a> ";
                                if((($row['id'] != $_SESSION['ID']) && ($_SESSION['ID'] == $equipo->getIDPropietario())) || $usuarioActual->admin())
                                    echo "<a class='btn btn-danger btn-xs' href='equipo_remove.php?id=".$id."&usuario=".$row['id']."'><span class='glyphicon glyphicon-remove-sign' data-toggle='tooltip' data-placement='top' title='Expulsar usuario'></span></a> ";
                            }
                        }
                        
                    echo "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";

        if(isset($_SESSION['ID']))
        {
            //se o usuario actual non ten equipo
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

    }//perfil
    
    if($tab == "torneos")
    {
        echo "<span>N&uacute;mero de torneos do equipo: ".$equipo->getNumTorneos()."</span>";
        
        echo "
            <table class='table table-striped table-hover'>
                <tr>
                    <th>Nome</th>
                </tr>
        ";

        $lista = $equipo->listaTorneos();
        if($lista->num_rows > 0)
        {
            while($row = $lista->fetch_assoc())
            {
                echo "<tr>";
                    echo "<td><a href='torneo.php?id=".$row['id']."'>".$row['nome']."</a></td>";  
                echo "</tr>";
            }
        }

        echo "</table>";
        
    }//torneos
    
    if($tab == "editar")
    {
        if(($_SESSION['ID'] == $equipo->getIDPropietario()) || $usuarioActual->admin())
        {
?>

    <form class="form-horizontal" role="form" id="formEditar" action="equipo.php" method="post">
        <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
        <div class="form-group">
            <label for="nome" class="col-sm-3 control-label">Nome do equipo</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="nome" name="nome" maxlength="50" placeholder="Nome de equipo" value="<?php echo $equipo->getNome();?>" disabled required>
            </div>
        </div>
        <div class="form-group">
            <label for="codigo" class="col-sm-3 control-label">C&oacute;digo de ingreso</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="codigo" name="codigo" maxlength="10" placeholder="C&oacute;digo" value="<?php echo $equipo->getCodigoIngreso();?>" disabled required>
            </div>
        </div>

        <div class="form-group">                      
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" id="btnHabilitar" name="btnHabilitar" onClick="activarEdicionEquipo()"><span class='glyphicon glyphicon-edit'></span> Habilitar edici&oacute;n</button>    
                <button type="submit" class="btn btn-success" id="accion" name="accion" value="editar" disabled style="visibility:hidden">Editar perfil</button>
            </div>
        </div>
    </form> 
        
<?php  
        } 
    }//editar
            
?>
        </fieldset>
    

<?php

        }//else non pulsou accion
    }//else coñece id
?>

            
        </div>
    </div>

    
    
    
    



<?php include("footer.php"); ?>