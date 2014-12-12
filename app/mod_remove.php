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

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        
<?php
    //se chega sen loguear ou non é admin
    if(!isset($_SESSION['ID']) || !$usuarioActual->admin())
    {
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
    }
    else
    {
        //se non hai ningunha id
        if(!isset($_GET['id']) && !isset($_POST['id']) && !isset($_GET['torneo']) && !isset($_POST['torneo']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o usuario.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
        else
        {        
            $id;
            $torneo;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];            
            if(isset($_GET['torneo']))
                $torneo= $_GET['torneo'];
            if(isset($_POST['torneo']))
                $torneo= $_POST['torneo'];

            $user = new usuario($id);
            
            //se se pulsou o botón
            if(isset($_POST['accion']))
            {
                if($_POST['accion'] == "quitar")
                {
                    if($user->quitarMod($torneo))
                        aviso("success", "O usuario ".$user->getNome()." xa non &eacute; moderador no torneo.", "torneo.php?id=".$torneo, "Voltar ao torneo");
                    else
                        aviso("danger", "Ocorreu un erro ao retirar a moderaci&oacute;n.", "torneo.php?id=".$torneo, "Voltar ao torneo");

                }
                //se chegou sen o botón de dar admin
                else
                {
                    aviso("danger", "Ocorreu un erro.", "torneo.php?id=".$torneo, "Voltar ao torneo");
                }
            }
            //mostrar formulario inicial
            else
            {
                echo '
                    <form class="form-horizontal" role="form" id="formQuitarMod" action="mod_remove.php" method="post">
                        <input type="hidden" id="id" name="id" value="'.$id.'">
                        <input type="hidden" id="torneo" name="torneo" value="'.$torneo.'">                  
                        <div class="alert alert-info" role="alert">Est&aacute;s seguro de retirar o cargo de moderador/a a <b>'.$user->getNome().'?</b></div>                
                        <div class="form-group">                
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-danger" id="accion" name="accion" value="quitar"><span class="glyphicon glyphicon-minus-sign"></span> Quitar moderador</button>
                                <a href="torneo.php?id='.$torneo.'" class="btn btn-default">Voltar ao torneo</a>
                            </div>
                          </div>
                    </form>
                ';
            }
        }
            
    }

?>

        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>