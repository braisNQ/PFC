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

            //se non ten equipo
            if(!$usuarioActual->getIDequipo())
            {
                //se se pulsou o botón
                if(isset($_POST['accion']))
                {
                    if($_POST['accion'] == "entrar")
                    {
                        //se o código é correcto
                        if($_POST['codigo'] == $equipo->getCodigoIngreso())
                        {
                            if($usuarioActual->entrarEquipo($id))
                                aviso("success", "Benvid@ ao equipo <b>".$equipo->getNome()."</b>.", "equipo.php?id=".$id, "Ir ao equipo");
                            else
                                aviso("danger", "Ocorreu un erro ao unirse ao equipo.", "equipo.php?id=".$id, "Voltar ao perfil");
                        }
                        else
                            aviso("danger", "O c&oacute;digo introducido non &eacute; correcto.", "equipo_join.php?id=".$id, "Tentar de novo");


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
                        <form class="form-horizontal" role="form" id="formEntrarEquipo" action="equipo_join.php" method="post">
                            <input type="hidden" id="id" name="id" value="'.$id.'">                    
                            <div class="alert alert-info" role="alert">
                                <div class="text-center">            
                                    Introduce o c&oacute;digo de ingreso do equipo <b>'.$equipo->getNome().'</b>
                                    <br /><br />         
                                    <div class="form-group">         
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="codigo" name="codigo" maxlength="10" placeholder="C&oacute;digo" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" id="accion" name="accion" value="entrar">Entrar en equipo</button>
                                </div>
                            </div> 
                        </form>
                    ';
                }
            }
            //se ten equipo
            else
            {
                aviso("danger", "Xa tes un equipo!.", "equipo.php?id=".$usuarioActual->getIDequipo(), "Ver o meu equipo");
            }
        }
            
    }

?>

        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>