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
            <li class="active"><a href="lista_torneos.php">Torneos</a></li>            
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
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
    }
    else
    {
        //se non hai ningunha id
        if(!isset($_GET['id']) && !isset($_POST['id']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o equipo.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
        else
        {
            $id;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];
            $torneo = new torneo($id);

            //se é capitán
            if($usuarioActual->capitan())
            {
                //se se pulsou o botón
                if(isset($_POST['accion']))
                {
                    if($_POST['accion'] == "entrar")
                    {
                        if($torneo->agregarEquipo($usuarioActual->getIDequipo()))
                            aviso("success", "Equipo inscrito correctamente no torneo <b>".$torneo->getNome()."</b>.", "torneo.php?id=".$id, "Ir ao torneo");
                        else
                            aviso("danger", "Ocorreu un erro ao inscribir ao equipo.", "torneo.php?id=".$id, "Voltar ao torneo");
                    }
                    //se chegou sen o botón de entrar
                    else
                    {
                        aviso("danger", "Ocorreu un erro.", "torneo.php?id=".$id, "Voltar ao torneo");
                    }
                }
                //mostrar formulario inicial
                else
                {
                    echo '
                        <form class="form-horizontal" role="form" id="formEntrarTorneo" action="torneo_join.php" method="post">
                            <input type="hidden" id="id" name="id" value="'.$id.'">                    
                            <div class="alert alert-info" role="alert">
                                <div class="text-center">        
                                    Desexas anotar ao teu equipo no torneo <b>'.$torneo->getNome().'</b>?
                                    <br /><br /> 
                                    <button type="submit" class="btn btn-success" id="accion" name="accion" value="entrar">Entrar en torneo</button>
                                    <a class="btn btn-danger" href="lista_torneos.php" "role="button">Volver &aacute; lista</a>
                                </div>
                            </div> 
                        </form>
                    ';
                }
            }
            //se ten equipo
            else
            {
                aviso("danger", "Non eres propietario dun equipo.", "torneo.php?id=".$id, "Voltar ao torneo");
            }
        }
            
    }

?>

        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>