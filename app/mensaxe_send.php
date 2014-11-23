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

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        
<?php
    //se chega sen loguear
    if(!isset($_SESSION['ID']))
    {
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "index.php", "Voltar ao inicio");
    }
    else
    {
        //se non hai ningunha id
        if(!isset($_GET['id']) && !isset($_POST['id']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o usuario.", "index.php", "Voltar ao inicio");
        else
        {        
            $id;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];
            
            $resposta;
            if(isset($_GET['resposta']))
                $resposta= $_GET['resposta'];
            if(isset($_POST['resposta']))
                $resposta= $_POST['resposta'];
            
            $incidencia;
            if(isset($_GET['incidencia']))
                $incidencia= $_GET['incidencia'];
            if(isset($_POST['incidencia']))
                $incidencia= $_POST['incidencia'];
            
            
            //se se pulsou o botón
            if(isset($_POST['accion']))
            {
                if($_POST['accion'] == "enviar")
                {
                    /*
                    if($user->darAdmin())
                        aviso("success", "O usuario ".$user->getNome()." xa &eacute; administrador.", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
                    else
                        aviso("danger", "Ocorreu un erro no asignamento de administraci&oacute;n.", "usuario.php?id=".$id, "Voltar ao perfil");
                     * */
                     

                }
                //se chegou sen o botón de dar admin
                else
                {
                    aviso("danger", "Ocorreu un erro.", "mensaxe_send.php?id=".$id, "Intentar de novo");
                }
            }
            //mostrar formulario inicial
            else
            {
                echo '
                    <form class="form-horizontal" role="form" id="formDarAdmin" action="admin_give.php" method="post">
                        <input type="hidden" id="id" name="id" value="'.$id.'">                    
                        <div class="alert alert-info" role="alert">Est&aacute;s seguro de nomear a <b>'.$user->getNome().' como administrador?</b></div>                
                        <div class="form-group">                
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" id="accion" name="accion" value="dar"><span class="glyphicon glyphicon-plus-sign"></span> Facer administrador</button>
                                <a href="usuario.php?id='.$id.'" class="btn btn-default">Voltar ao perfil</a>
                            </div>
                          </div>
                    </form>
                ';
                
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
                      <div class="form-group">                      
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default" id="btnHabilitar" name="btnHabilitar" onClick="activarEdicionUsuario()"><span class='glyphicon glyphicon-edit'></span> Habilitar edici&oacute;n</button>    
                            <button type="submit" class="btn btn-success" id="accion" name="accion" value="editar"  onClick="md5editar()" disabled style="visibility:hidden">Editar perfil</button>
                        </div>
                      </div>
                             
                     </fieldset>
                </form>
            </div>
        </div>
        <?php
            
            
            
            }
        }
            
    }

?>

        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>