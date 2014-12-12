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
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter a mensaxe.", "index.php", "Voltar ao inicio");
        else
        {        
            $id;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];
            
            $mensaxe = new mensaxe($id);

            //se a mensaxe non está dirixida ao usuario actual
            if($mensaxe->getDestinatario() != $_SESSION['ID'])
            {
                aviso("danger", "Ups! non deberías estar aqu&iacute;.", "index.php", "Voltar ao inicio");
            }
            else
            {            
                //se se pulsou o botón
                if(isset($_POST['accion']))
                {
                    if($_POST['accion'] == "eliminar")
                    {
                        if($mensaxe->eliminar())
                            aviso("success", "Mensaxe eliminada correctamente", "mensaxes.php", "Ir a mensaxes");
                        else
                            aviso("danger", "Ocorreu un erro ao eliminar a mensaxe.", "mensaxes.php", "Ir a mensaxes");
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
                    $mensaxe->setVisto();
                    
                ?>
                    <form class="form-horizontal" role="form" id="formMensaxe" action="mensaxe.php" method="post">
                        <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
                        <fieldset id="fieldMensaxe">
                        <legend>Mensaxe de <?php echo $mensaxe->getNomeRemitente();?></legend>             
                         <div class="form-group">
                            <label for="asunto" class="col-sm-2 control-label">Asunto</label>
                            <div class="col-sm-4">
                                <?php echo $mensaxe->getAsunto();?>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="contrasinal" class="col-sm-2 control-label">Mensaxe</label>
                            <div class="col-sm-4">
                                <?php echo $mensaxe->getTexto();?>
                            </div>
                         </div>
                        <div class="form-group">                
                            <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-danger" id="accion" name="accion" value="eliminar">Eliminar</button>
                                    <a href="mensaxe_send.php?id=<?php echo $mensaxe->getRemitente();?>" class="btn btn-success">Respostar</a>
                                    <a href="mensaxes.php" class="btn btn-default">Voltar &aacute; lista de mensaxes</a>
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
            
    }

?>

        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>