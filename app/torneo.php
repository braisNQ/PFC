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
        <div class="jumbotron">
<?php

                
    //se non existe ID
    if(!isset($_GET['id']) && !isset($_POST['id']))
    {
        aviso("danger", "Produciuse un erro.", "lista_torneos.php", "Voltar &aacute; lista");
    }
    //coñece id
    else
    {
        $id;
        if(isset($_GET['id']))
            $id= $_GET['id'];
        if(isset($_POST['id']))
            $id= $_POST['id'];
        $torneo = new torneo($id);
        
        $tab;
        if(isset($_GET['tab']))
            $tab =$_GET['tab'];
        else
            $tab = "clasificacion";

        //se se seleccionou o botón de acción
        if(isset($_POST['accion']) )
        {
            //se seleccionou editar
            if($_POST['accion'] == 'editar')
            {
                if($usuarioActual->modTorneo($id) || $usuarioActual->admin())
                {
                    $n = $_POST['nome'];
                    $v = $_POST['numero_voltas'];
                    $pv = $_POST['puntos_victoria'];
                    $pe = $_POST['puntos_empate'];
                    $pd = $_POST['puntos_derrota'];
                    
                    if($torneo->editar($n, $v, $pv, $pe, $pd))
                        aviso("success", "O torneo <b>".$n."</b> foi actualizado correctamente.", "torneo.php?id=".$id, "Voltar ao perfil");
                    else
                        aviso("danger", "Houbo alg&uacute;n problema durante a modificaci&oacute;n do torneo", "torneo.php?id=".$id."&tab=editar", "Voltar ao perfil");
                }
                else
                {
                    aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o torneo solicitado.", "torneo.php?id=".$id, "Voltar ao perfil");
                }
            }
            else
            {
                aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o torneo solicitado.", "torneo.php?id=".$id, "Voltar ao perfil");
            }
        }
        //se carga a páxina sen pulsar ningún botón
        //presenta o formulario por defecto
        else
        {
            
        ?>
        
        <fieldset>
            <legend><?php echo $torneo->getNome();?></legend>
    
            <ul class="nav nav-tabs" role="tablist">
                <li <?php if($tab=="clasificacion") echo 'class="active"'; ?>><a href="torneo.php?id=<?php echo $id; ?>&tab=clasificacion">Clasificaci&oacute;n</a></li>
                <li <?php if($tab=="partidos") echo 'class="active"'; ?>><a href="torneo.php?id=<?php echo $id; ?>&tab=partidos">Partidos restantes</a></li>
                <li <?php if($tab=="mods") echo 'class="active"'; ?>><a href="torneo.php?id=<?php echo $id; ?>&tab=mods">Moderadores</a></li>
                <?php
                    if(isset($_SESSION['ID']))
                    {
                        if($usuarioActual->modTorneo($id) || $usuarioActual->admin())
                        {
                            echo '<li ';
                            if($tab=="editar")
                                echo 'class="active"';
                            echo '><a href="torneo.php?id='.$id.'&tab=editar">Editar</a></li>';
                        }
                    }
                ?>
            </ul>
            
            <br />
    
<?php
    if($tab == "clasificacion")
    {
        if(isset($_SESSION['ID']))
        {
            //se o usuario actual é capitán e o torneo non está iniciado e o equipo do usuario non está inscrito
            if($usuarioActual->capitan() && !$torneo->iniciado() && !$usuarioActual->enTorneo($id))
            {
                echo '
                    <div class="col-sm-2">            
                        <a href="torneo_join.php?id='.$id.'" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Inscribirse en torneo</a>
                    </div>
                ';
            }

            //se o usuario actual é admin ou moderador do torneo
            if($usuarioActual->modTorneo($id) || $usuarioActual->admin())
            {
                echo "
                <br /><br />
                <fieldset>
                        <legend>Opci&oacute;ns de administraci&oacute;n</legend>
                ";
                if(!$torneo->iniciado())
                {
                    echo '
                        <div class="col-sm-2">            
                            <a href="torneo_start.php?id='.$id.'" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Iniciar torneo</a>
                        </div>
                    ';
                }
                echo'
                    <div class="col-sm-2">
                        <a href="torneo_delete.php?id='.$id.'" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar torneo</a>
                    </div>
                ';
                echo "</fieldset>";
            }
            echo "<br /><br />";
        }

        include("clasificacion.php");

    }//clasificacion
    
    if($tab == "partidos")
    {
        
    }//partidos

    if($tab == "mods")
    {
        
    }//mods
    
    if($tab == "editar")
    {
        if($usuarioActual->modTorneo($id) || $usuarioActual->admin())
        {
?>


    <form class="form-horizontal" role="form" id="formEditar" action="torneo.php" method="post">
        <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
        <div class="form-group">
            <label for="nome" class="col-sm-3 control-label">Nome do torneo</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="nome" name="nome" maxlength="50" placeholder="Nome de torneo" value="<?php echo $torneo->getNome();?>" disabled required>
            </div>
        </div>
        <div class="form-group">
            <label for="codigo" class="col-sm-3 control-label">N&uacute;mero de voltas</label>
            <div class="col-sm-2">
              <input type="number" class="form-control" id="numero_voltas" name="numero_voltas" min="1" max="10" step="1"  placeholder="2" value="<?php echo $torneo->getNumVoltas();?>" disabled required>
            </div>
        </div>
        <div class="form-group">
            <label for="codigo" class="col-sm-3 control-label">Puntos por victoria</label>
            <div class="col-sm-2">
              <input type="number" class="form-control" id="puntos_victoria" name="puntos_victoria" min="-10" max="10" step="1" value="<?php echo $torneo->getPuntosVictoria();?>" disabled  placeholder="3" required>
            </div>
        </div> 
        <div class="form-group">
            <label for="codigo" class="col-sm-3 control-label">Puntos por empate</label>
            <div class="col-sm-2">
              <input type="number" class="form-control" id="puntos_empate" name="puntos_empate" min="-10" max="10" step="1" value="<?php echo $torneo->getPuntosEmpate();?>" disabled  placeholder="1" required>
            </div>
        </div> 
        <div class="form-group">
            <label for="codigo" class="col-sm-3 control-label">Puntos por derrota</label>
            <div class="col-sm-2">
              <input type="number" class="form-control" id="puntos_derrota" name="puntos_derrota" min="-10" max="10" step="1" value="<?php echo $torneo->getPuntosDerrota();?>" disabled  placeholder="0" required>
            </div>
        </div> 
        <div class="form-group">                      
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" id="btnHabilitar" name="btnHabilitar" onClick="activarEdicionTorneo()"><span class='glyphicon glyphicon-edit'></span> Habilitar edici&oacute;n</button>    
                <button type="submit" class="btn btn-success" id="accion" name="accion" value="editar" disabled style="visibility:hidden">Editar perfil</button>
            </div>
        </div>
    </form> 
        
<?php
        } 
    }//editar
    
    
            
            
?>
        </fieldset>
    

<?php

        }//else non pulsou accion
    }//else coñece id
?>

            
        </div>
    </div>

    
    
    
    



<?php include("footer.php"); ?>