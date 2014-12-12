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
            aviso("danger", "Produciuse un erro.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
    }
    //coñece id
    else
    {
        $id;
        if(isset($_GET['id']))
            $id= $_GET['id'];
        if(isset($_POST['id']))
            $id= $_POST['id'];
        
        $partido = new partido($id);
        
        $tab="perfil";
        if(isset($_GET['tab']))
            $tab =$_GET['tab'];        
        if(isset($_POST['tab']))
            $tab =$_POST['tab'];


        if($tab == "perfil")
        {
        
        ?>
            <fieldset>
                <legend><?php echo $partido->getNomeEQ1();?> vs <?php echo $partido->getNomeEQ2();?> </legend>
                <form class="form-horizontal" role="form" id="formEditar" action="partido.php" method="post">
                    <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
                    <input type="hidden" value="<?php echo $tab;?>" name="tab" id="tab">
                    <div class="form-group">
                        <label for="nome" class="col-sm-3 control-label">Resultado EQ1</label>
                        <div class="col-sm-2"><?php echo $partido->resultado1();?></div>
                    </div>
                    <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">Resultado EQ2</label>
                        <div class="col-sm-2"><?php echo $partido->resultado2();?></div>
                    </div>
                    <div class="form-group">
                        <label for="codigo" class="col-sm-3 control-label">Data</label>
                        <div class="col-sm-2"><?php echo $partido->getData();?></div>
                    </div>
                </form> 
            </fieldset>

        <?php
        if(isset($_SESSION['ID']))
            if($usuarioActual->modTorneo($id) || $usuarioActual->admin())
            {
                echo "<a class='btn btn-default' href='partido.php?id=".$id."&tab=editar'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Editar resultado'></span> Editar resultado</a> ";
            }
        }
        else
        {
            if(!isset($_SESSION['ID']))
            {
                aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o partido solicitado.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
            }
            else
            {
                if($tab == "editar")
                {
                    if(!$usuarioActual->admin() && !$usuarioActual->modTorneo($partido->getIDtorneo()))
                    {
                        aviso("danger", "Houbo alg&uacute;n erro ao intentar recuperar o partido solicitado.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
                    }
                    else
                    {
                        if(isset($_POST['accion']) )
                        {
                            //se seleccionou editar
                            if($_POST['accion'] == 'editar')
                            {
                                $r1 = $_POST['resultado_1'];
                                $r2 = $_POST['resultado_2'];
                                    
                                if($partido->editar($r1, $r2))
                                    aviso("success", "O partido foi actualizado correctamente.", "partido.php?id=".$id, "Voltar ao partido");
                                else
                                    aviso("danger", "Houbo alg&uacute;n problema durante a modificaci&oacute;n do partido", "partido.php?id=".$id, "Voltar ao partido");
                            }
                            else
                            {
                                aviso("danger", "Houbo alg&uacute;n erro.", "partido.php?id=".$id, "Voltar ao partido");
                            }
                        }
                        else
                        {
                    ?>
                        <fieldset>
                            <legend><?php echo $partido->getNomeEQ1();?> vs <?php echo $partido->getNomeEQ2();?> </legend>
                            <form class="form-horizontal" role="form" id="formEditar" action="partido.php" method="post">
                                <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
                                <input type="hidden" value="<?php echo $tab;?>" name="tab" id="tab">
                                <div class="form-group">
                                    <label for="nome" class="col-sm-3 control-label">Resultado EQ1</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" id="resultado_1" name="resultado_1" min=0 step=1 placeholder="0" value="<?php echo $partido->resultado1();?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="codigo" class="col-sm-3 control-label">Resultado EQ2</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" id="resultado_2" name="resultado_2" min=0 step=1 placeholder="0" value="<?php echo $partido->resultado2();?>" required>
                                    </div>
                                </div>
                                <div class="form-group">                
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success" id="accion" name="accion" value="editar">Editar partido</button>
                                        <a href="partido.php?id=<?php echo $id;?>" class="btn btn-default">Voltar ao partido</a>
                                    </div>
                                </div>
                            </form> 
                        </fieldset>
                 <?php

                        }
                    }
                }
                if($tab == "rematar")
                {

                }
                if($tab == "configurar")
                {
                    /*
                    if($_SESSION['ID'] != $partido->capitan1() && $_SESSION['ID'] != $partido->capitan1())
                    {
                        aviso("danger", "Produciuse un erro.", "lista_torneos.php", "Voltar &aacute; lista de torneos");
                    }
                    else
                    {

                    }
                    */

                }
            }
        }
    
    }
?>

            
        </div>
    </div>

    
    
    
    



<?php include("footer.php"); ?>