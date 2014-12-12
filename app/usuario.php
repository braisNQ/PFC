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
            <li class="active"><a href="lista_usuarios.php">Usuarios</a></li>
            <li><a href="lista_equipos.php">Equipos</a></li>
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


<?php

    $id;
    $user;
    //se non se coñece a id nin por get nin por post, ou non hai usuario logueado
    //lanza erro
    if((!isset($_GET['id']) && !isset($_POST['id'])) || !isset($_SESSION['ID'])  )
    {
        aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o usuario solicitado", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
    }
    else
    {        
        $id;
        if(isset($_GET['id']))
            $id= $_GET['id'];
        if(isset($_POST['id']))
            $id= $_POST['id'];
        $user = new usuario($id);
        
        //se non existe o usuario correspondente á ID solicitada
        //lanza erro
        if(!$user->existe())
        {
            aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o usuario solicitado", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
        }
        else
        {
            //se se seleccionou o botón de acción
            if(isset($_POST['accion']) )
            {
                //se seleccionou editar
                if($_POST['accion'] == 'editar')
                {
                    if($usuarioActual->admin() || ($id == $_SESSION['ID']))
                    {
                        $n = $_POST['nome'];
                        $p = $_POST['contrasinal'];
                        
                        if($user->editar($n, $p))
                            aviso("success", $n." foi actualizado correctamente.", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
                        else
                            aviso("danger", "Houbo alg&uacute;n problema durante a modificaci&oacute;n do perfil", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
                    }
                    else
                    {
                        aviso("danger", "Houbo alg&uacute;n problema durante a modificaci&oacute;n do perfil", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
                    }
                }
                else
                {
                    aviso("danger", "Houbo alg&uacute;n problema durante a modificaci&oacute;n do perfil", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
                }
            }
            //se carga a páxina sen pulsar ningún botón
            //presenta o formulario por defecto
            else
            {
                
?>

        <div class="container">
            <div class="jumbotron">
                <form class="form-horizontal" role="form" id="formEditar" action="usuario.php" method="post">
                    <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
                    <fieldset id="fieldEditar">
                    <legend><?php echo $user->getLogin();?></legend>             
                     <div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">Nome</label>
                        <div class="col-sm-4">
                              <input type="text" class="form-control" id="nome" name="nome" maxlength="50" value="<?php echo $user->getNome();?>" disabled required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="contrasinal" class="col-sm-2 control-label">Contrasinal</label>
                        <div class="col-sm-4">
                              <input type="password" class="form-control" id="contrasinal" name="contrasinal" maxlength="50" placeholder="Escribe un novo contrasinal" disabled required>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Equipo</label>
                        <label class="col-sm-4 control-label">
                            <?php
                                if($user->getNomeEquipo() != '')
                                    echo "<a href='equipo.php?id=".$user->getIDEquipo() ."'>".$user->getNomeEquipo() ."</a>";
                                else
                                    echo "Sen equipo";
                            ?>
                        </label>
                     </div>
                     <?php
                        if($usuarioActual->admin() || ($id == $_SESSION['ID']))
                        {
                        ?>
                          <div class="form-group">                      
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-default" id="btnHabilitar" name="btnHabilitar" onClick="activarEdicionUsuario()"><span class='glyphicon glyphicon-edit'></span> Habilitar edici&oacute;n</button>    
                                <button type="submit" class="btn btn-success" id="accion" name="accion" value="editar"  onClick="md5editar()" disabled style="visibility:hidden">Editar perfil</button>
                            </div>
                          </div>
                        <?php
                        }
                        ?>
                             
                     </fieldset>
                </form>
                
                <?php
                //se o usuario que visita o perfil é un administrador permíteselle eliminar o usuario
                if($usuarioActual->admin())
                {
                    echo '                
                    <fieldset>
                        <legend>Opci&oacute;ns de administraci&oacute;n</legend>
                    ';
                    
                    if($id != $_SESSION['ID'])
                    {
                        echo'
                            <div class="col-sm-2">
                                <a href="usuario_delete.php?id='.$id.'" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar Usuario</a>
                            </div>
                        ';
                        if($user->admin())
                            echo '                    
                                <div class="col-sm-2">
                                    <a href="admin_remove.php?id='.$id.'" class="btn btn-default"><span class="glyphicon glyphicon-minus-sign"></span> Quitar administrador</a>
                                </div>
                            ';
                        else
                        {
                            echo '                    
                                <div class="col-sm-2">
                                    <a href="admin_give.php?id='.$id.'" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Facer administrador</a>
                                </div>
                            ';
                            echo '                    
                                <div class="col-sm-2">
                                    <a href="mod_give.php?id='.$id.'" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Facer moderador</a>
                                </div>
                            ';
                        }
                    }
                    echo '</fieldset>';
                }
                ?>
            </div>
        </div>

<?php
            } //else presenta formulario defecto            
        } // existe usuario seleccionado
    }//seleccionoouse un usuario
?>    

<?php include("footer.php"); ?>