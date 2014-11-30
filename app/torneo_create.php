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
            <li><a href="equipos.php">Equipos</a></li>
            <li class="lista_active"><a href="lista_torneos.php">Torneos</a></li>            
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
            //se chegou por un botón
            if(isset($_POST['accion']))
            {
                //botón crear
                if($_POST['accion'] == 'crear')
                {
                    $bd = new BD();
                    
                    //se non existe un torneo con ese nome
                    if(!$bd->existeTorneo($_POST['nome']))
                    {
                        //crear torneo
                        if($bd->crearTorneo($_POST['nome'], $_POST['numero_voltas'], $_POST['puntos_victoria'], $_POST['puntos_empate'], $_POST['puntos_derrota']))
                        {
                            aviso("success", "O torneo <b>".$_POST['nome']."</b> foi creado con &eacute;xito.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
                        }
                        //se creou mal
                        else
                        {
                            aviso("danger", "Houbo un erro na creaci&oacute;n do torneo.", "torneo_create.php", "Voltar intentalo");
                        }
                    }
                    else
                    {
                        aviso("danger", "Xa existe un torneo con nome <b>".$_POST['nome']."</b>.", "torneo_create.php", "Voltar intentalo");
                    }
                }
                //outro botón
                else
                {
                    aviso("danger", "Houbo un erro na creaci&oacute;n do torneo.", "torneo_create.php", "Voltar intentalo");
                }
            }
            //formulario por defecto
            else
            {
            ?>
                <form class="form-horizontal" role="form" id="formCrearTorneo" action="torneo_create.php" method="post">
                    <div class="form-group">
                        <label for="nome" class="col-sm-3 control-label">Nome do torneo</label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" id="nome" name="nome" maxlength="50" placeholder="Nome de equipo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">N&uacute;mero de voltas</label>
                        <div class="col-sm-2">
                          <input type="number" class="form-control" id="numero_voltas" name="numero_voltas" min="1" max="10" step="1"  placeholder="2" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">Puntos por victoria</label>
                        <div class="col-sm-2">
                          <input type="number" class="form-control" id="puntos_victoria" name="puntos_victoria" min="-10" max="10" step="1"  placeholder="3" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">Puntos por empate</label>
                        <div class="col-sm-2">
                          <input type="number" class="form-control" id="puntos_empate" name="puntos_empate" min="-10" max="10" step="1"  placeholder="1" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">Puntos por derrota</label>
                        <div class="col-sm-2">
                          <input type="number" class="form-control" id="puntos_derrota" name="puntos_derrota" min="-10" max="10" step="1"  placeholder="0" required>
                        </div>
                    </div>              
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-2">
                            <button type="submit" class="btn btn-info" name="accion" value="crear">Crear torneo</button>
                        </div>
                    </div>
                </form>                    
            <?php                
            } 
        }
?>
          
          
          
          
          
      </div> <!--jumbo -->  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>