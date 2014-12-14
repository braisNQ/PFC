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
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "index.php", "Voltar ao Inicio");
    }
    else
    {
        //se non hai ningunha id
        if(!isset($_GET['id']) && !isset($_POST['id']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o usuario.", "index.php", "Voltar ao Inicio");
        else
        {        
            $id;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];
            
            $user = new usuario($id);
            
            //se se pulsou o botón
            if(isset($_POST['accion']))
            {
                if($_POST['accion'] == "enviar")
                {
                    $asunto=$_POST['asunto'];
                    $txt=$_POST['txt'];
                    $data=date('Y-m-d H:i:s');

                    if($usuarioActual->enviarMensaxe($id,$asunto,$txt,$data))
                        aviso("success", "Mensaxe enviada correctamente", "mensaxes.php", "Ir a mensaxes");
                    else
                        aviso("danger", "Ocorreu ao enviar a mensaxe.", "mensaxe_send.php?id=".$id, "Tentar de novo");
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
                
            ?>
                <form class="form-horizontal" role="form" id="formEnviarMensaxe" action="mensaxe_send.php" method="post">
                    <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
                    <fieldset id="fieldEditar">
                    <legend>Mensaxe para <?php echo $user->getNome();?></legend>             
                     <div class="form-group">
                        <label for="asunto" class="col-sm-2 control-label">Asunto</label>
                        <div class="col-sm-4">
                              <input type="text" class="form-control" id="asunto" name="asunto" maxlength="50" placeholder="Asunto" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="contrasinal" class="col-sm-2 control-label">Mensaxe</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="txt" name="txt" rows=10 placeholder="Escribe unha ensaxe" required></textarea>
                        </div>
                     </div>
                    <div class="form-group">                
                        <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" id="accion" name="accion" value="enviar">Enviar</button>
                                <a href="lista_usuarios.php" class="btn btn-default">Voltar &aacute; lista de usuarios</a>
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