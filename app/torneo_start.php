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

            if($usuarioActual->modTorneo($id) || $usuarioActual->admin())
            {
                //se se pulsou o botón
                if(isset($_POST['accion']))
                {
                    if($_POST['accion'] == "iniciar")
                    {
                        $exito = true;
                        //get lista equipos en equipoTorneo
                        //for num_voltas
                        // foreach equipo
                        // crear partido

                        $voltas = $torneo->getVoltas();

                        for($i=0; $i<$voltas;$i++)
                        {
                            $conta1 = 0;
                            $lista1 = $torneo->listaEquipos();

                            if($lista1->num_rows > 0)
                            {
                                while($l1 = $lista1->fetch_assoc())
                                {
                                $conta1++;
                                    $lista2 = $torneo->listaEquipos();
                                    $conta2=0;
                                    while($l2 = $lista2->fetch_assoc())
                                    {
                                        $conta2++;
                                        if($conta2 > $conta1)
                                        {
                                            $e1 = 0;
                                            $e2= 0;
                                            if($i % 2 == 0)
                                            {
                                                $e1 = $l1['ID_equipo'];
                                                $e2 = $l2['ID_equipo'];
                                            }
                                            else
                                            {
                                                $e1 = $l2['ID_equipo'];
                                                $e2 = $l1['ID_equipo'];
                                            }
                                            
                                            if(!$torneo->crearPartido($e1,$e2))
                                                $exito = false;

                                        }
                                    }
                                }
                            }
                        }

                        if($exito && $torneo->iniciar())
                            aviso("success", "O torneo <b>".$torneo->getNome()."</b> foi iniciado con &eacute;xito.", "torneo.php?id=".$id, "Ir ao torneo");
                        else
                            aviso("danger", "Ocorreu un erro ao iniciar o torneo.", "torneo.php?id=".$id, "Voltar ao torneo");
                    }
                    //se chegou sen o botón de iniciar
                    else
                    {
                        aviso("danger", "Ocorreu un erro.", "torneo.php?id=".$id, "Voltar ao torneo");
                    }
                }
                //mostrar formulario inicial
                else
                {
                    echo '
                        <form class="form-horizontal" role="form" id="formEntrarTorneo" action="torneo_start.php" method="post">
                            <input type="hidden" id="id" name="id" value="'.$id.'">                    
                            <div class="alert alert-info" role="alert">
                                <div class="text-center">        
                                    Desexas iniciar o torneo <b>'.$torneo->getNome().'</b>?
                                    <br /><br /> 
                                    <button type="submit" class="btn btn-success" id="accion" name="accion" value="iniciar">Si</button>
                                    <a class="btn btn-danger" href="lista_torneos.php" "role="button">Non</a>
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