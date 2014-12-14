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
    if(!isset($_SESSION['ID']))
    {
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
    }
    else
    {
        //se non hai ningunha id
        if(!isset($_GET['id']) && !isset($_POST['id']) && !isset($_GET['usuario']) && !isset($_POST['usuario']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o usuario.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
        else
        {        
            $id;
            $usuario;
            if(isset($_GET['id']))
                $id= $_GET['id'];
            if(isset($_POST['id']))
                $id= $_POST['id'];            
            if(isset($_GET['usuario']))
                $usuario= $_GET['usuario'];
            if(isset($_POST['usuario']))
                $usuario= $_POST['usuario'];

            $equipo = new equipo($id);
            $user = new usuario($usuario);

            if(!$usuarioActual->admin() && $_SESSION['ID'] != $equipo->getIDPropietario())
            {
                aviso("danger", "Ups! non deberías estar aqu&iacute;.", "lista_equipos.php", "Voltar &aacute; lista de equipos");
            } 
            else
            {            
                //se se pulsou o botón
                if(isset($_POST['accion']))
                {
                    if($_POST['accion'] == "expulsar")
                    {
                        if($user->sairEquipo())
                            aviso("success", "O usuario ".$user->getNome()." xa non pertence ao equipo ".$equipo->getNome(), "equipo.php?id=".$id, "Voltar ao equipo");
                        else
                            aviso("danger", "Ocorreu un erro ao retirar a moderaci&oacute;n.", "equipo.php?id=".$id, "Voltar ao equipo");

                    }
                    else
                    {
                        aviso("danger", "Ocorreu un erro.", "equipo.php?id=".$id, "Voltar ao equipo");
                    }
                }
                //mostrar formulario inicial
                else
                {
                    echo '
                        <form class="form-horizontal" role="form" id="formExpulsar" action="equipo_remove.php" method="post">
                            <input type="hidden" id="id" name="id" value="'.$id.'">
                            <input type="hidden" id="usuario" name="usuario" value="'.$usuario.'">                  
                            <div class="alert alert-info" role="alert">Est&aacute;s seguro de expulsar a <b>'.$user->getNome().'?</b></div>                
                            <div class="form-group">                
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-danger" id="accion" name="accion" value="expulsar"><span class="glyphicon glyphicon-minus-sign"></span> Expulsar membro</button>
                                    <a href="equipo.php?id='.$id.'" class="btn btn-default">Voltar ao equipo</a>
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