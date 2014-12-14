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
            <li class="lista_active"><a href="equipos.php">Equipos</a></li>
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
            //se non ten equipo
            if(!$usuarioActual->getIDequipo())
            {
                //se chegou por un botón
                if(isset($_POST['accion']))
                {
                    //botón crear
                    if($_POST['accion'] == 'crear')
                    {
                        $bd = new BD();
                        
                        //se non existe o nome do equipo na BD
                        if(!$bd->existeEquipo($_POST['nome']))
                        {
                            //crear equipo
                            if($bd->crearEquipo($_SESSION['ID'], $_POST['nome'], $_POST['codigo']))
                            {
                                //modificar usuario actual para indicar ID_equipo
                                if($usuarioActual->entrarEquipoCreado())
                                {
                                    aviso("success", "O equipo ".$_POST['nome']." foi creado con &eacute;xito.", "equipo.php?id=".$usuarioActual->getIDequipo(), "Ver equipo");
                                }
                                //se falla ao modificar
                                else
                                {
                                    aviso("danger", "Houbo erros durante a creaci&oacute;n do equipo.", "lista_equipos.php", "Ir &aacute; lista de equipos");
                                }
                            }
                            //se creou mal
                            else
                            {
                                aviso("danger", "Houbo un erro na creaci&oacute;n do equipo.", "equipo_create.php", "Voltar intentalo");
                            }
                        }
                        else
                        {
                            aviso("danger", "Xa existe un equipo con nome ".$_POST['nome'].".", "equipo_create.php", "Voltar intentalo");
                        }
                    }
                    //outro botón
                    else
                    {
                        aviso("danger", "Houbo un erro na creaci&oacute;n do equipo.", "equipo_create.php", "Voltar intentalo");
                    }
                }
                //formulario por defecto
                else
                {
                ?>
                    <form class="form-horizontal" role="form" id="formCrearEquipo" action="equipo_create.php" method="post">
                        <div class="form-group">
                        <label for="nome" class="col-sm-3 control-label">Nome do equipo</label>
                        <div class="col-sm-5">
                              <input type="text" class="form-control" id="nome" name="nome" maxlength="50" placeholder="Nome de equipo" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">C&oacute;digo de ingreso</label>
                        <div class="col-sm-2">
                              <input type="text" class="form-control" id="codigo" name="codigo" maxlength="10" placeholder="C&oacute;digo" required>
                        </div>
                      </div>                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-2">
                          <button type="submit" class="btn btn-info" name="accion" value="crear">Crear equipo</button>
                        </div>
                      </div>
                    </form>                    
                <?php                
                }                
            }
            else
            {
                aviso("danger", "Xa pertences a un equipo.", "equipo.php?id=".$usuarioActual->getIDequipo(), "Ir ao meu equipo");
            }
        }
?>        
          
      </div> <!--jumbo -->  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>