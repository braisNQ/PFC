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

        <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">
        
<?php
    //se chega sen loguear
    if(!isset($_SESSION['ID']))
    {
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
    }
    else
    {
        //se non hai ningunha id
        if(!isset($_GET['id']) && !isset($_POST['id']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o equipo.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
        else
        {
            $id;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];
            $equipo = new equipo($id);

            //se non é o teu equipo
            if($id != $usuarioActual->getIDequipo())
            {
                aviso("danger", "Ups! non deberías estar aqu&iacute;.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
            }
            else
            {
                //se se pulsou o botón
                if(isset($_POST['accion']))
                {
                    if($_POST['accion'] == "sair")
                    {
                        if($usuarioActual->sairEquipo())
                            aviso("success", "Xa non eres membro do equipo <b>".$equipo->getNome()."</b>.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
                        else
                            aviso("danger", "Ocorreu un erro ao sa&iacute;r do equipo.", "equipo.php?id=".$id, "Voltar ao perfil");
                    }
                    //se chegou sen o botón de eliimnar
                    else
                    {
                        aviso("danger", "Ocorreu un erro.", "equipo.php?id=".$id, "Voltar ao perfil");
                    }
                }
                //mostrar formulario inicial
                else
                {
                    echo '
                        <form class="form-horizontal" role="form" id="formSairEquipo" action="equipo_leave.php" method="post">
                            <input type="hidden" id="id" name="id" value="'.$id.'">                    
                            <div class="alert alert-info" role="alert">Est&aacute;s seguro de querer sa&iacute;r do equipo <b>'.$equipo->getNome().'</b>?</div>                
                            <div class="form-group">                
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-danger" id="accion" name="accion" value="sair"><span class="glyphicon glyphicon-remove-sign"></span> Sa&iacute;r do equipo</button>
                                    <a href="equipo.php?id='.$id.'" class="btn btn-default">Voltar ao perfil</a>
                                </div>
                              </div>
                        </form>
                    ';
                }
            }
        }
            
    }

?>

        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>