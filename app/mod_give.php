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
        if(!isset($_GET['id']) && !isset($_POST['id']))
            aviso("danger", "Ocorreu alg&uacute;n erro ao obter o usuario.", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
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
                if($_POST['accion'] == "dar")
                {
                    $torneo = $_POST['torneo'];
                    if($user->darMod($torneo))
                        aviso("success", "O usuario ".$user->getNome()." xa &eacute; moderador no torneo.", "lista_usuarios.php", "Voltar &aacute; lista de usuarios");
                    else
                        aviso("danger", "Ocorreu un erro no asignamento de administraci&oacute;n.", "usuario.php?id=".$id, "Voltar ao perfil");

                }
                //se chegou sen o botón de dar admin
                else
                {
                    aviso("danger", "Ocorreu un erro.", "usuario.php?id=".$id, "Voltar ao perfil");
                }
            }
            //mostrar formulario inicial
            else
            {
                echo '
                    <form class="form-horizontal" role="form" id="formDarMod" action="mod_give.php" method="post">
                        <input type="hidden" id="id" name="id" value="'.$id.'">                    
                        <div class="alert alert-info" role="alert">Selecciona o torneo no que queres facer moderador a <b>'.$user->getNome().'</b></div>

                        <div class="form-group">
                            <label for="enquipo" class="col-sm-1 control-label input-sm">Torneos </label>
                            <div class="col-sm-2">
                                <select class="form-control" size="10" name="torneo" id="torneo">
                    ';
                    $bd = new bd();
                    $lista = $bd->listaTorneosMod($id);
                    if($lista->num_rows > 0)
                    {
                        while($row = $lista->fetch_assoc())
                        {
                            echo "<option value='".$row['ID']."'>".$row['nome']."</option>";
                        }
                    }
                echo '
                                </select>
                            </div>
                        </div>
                        <div class="form-group">                
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" id="accion" name="accion" value="dar"><span class="glyphicon glyphicon-plus-sign"></span> Facer moderador</button>
                                <a href="usuario.php?id='.$id.'" class="btn btn-default">Voltar ao perfil</a>
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