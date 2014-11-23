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
        <div class="jumbotron">
<?php

                
    //se non existe ID
    if(!isset($_GET['id']))
    {
        //se está logueado e non ten equipo
        //invita a crear
        if(isset($_SESSION['ID']) && !$usuarioActual->getIDequipo())
        {
            echo '
                <div class="container">
                    <div class="alert alert-info" role="alert">
                        Parece que non pertences a ning&uacute;n equipo....
                        <ul class="pager">
                            <li><a href="lista_equipos.php">Buscar equipo</a></li>
                            <li><a href="equipo_create.php">Crear equipo</a></li>
                        </ul>
                    </div>
                </div>
            ';
        }
        //se non está logueado
        //lanza aviso
        else
        {
            aviso("danger", "Produciuse un erro.", "lista_equipos.php", "Voltar &aacute; lista");
        }
    }
    //coñece id
    else
    {
        $id= $_GET['id'];
        $equipo = new equipo($id);
        
        $tab;
        if(isset($_GET['tab']))
            $tab =$_GET['tab'];
        else
            $tab = "perfil";
            
        ?>
        
        <fieldset>
            <legend><?php echo $equipo->getNome();?></legend>
    
            <ul class="nav nav-tabs" role="tablist">
              <li <?php if($tab=="perfil") echo 'class="active"'; ?>><a href="equipo.php?id=<?php echo $id; ?>&tab=perfil">Perfil</a></li>
              <li <?php if($tab=="membros") echo 'class="active"'; ?>><a href="equipo.php?id=<?php echo $id; ?>&tab=membros">Membros</a></li>
              <li <?php if($tab=="torneos") echo 'class="active"'; ?>><a href="equipo.php?id=<?php echo $id; ?>&tab=torneos">Torneos</a></li>
              <li <?php if($tab=="editar") echo 'class="active"'; ?>><a href="equipo.php?id=<?php echo $id; ?>&tab=editar">Editar</a></li>
            </ul>
            
            <br />
    
<?php
    if($tab == "perfil")
    {
    ?>
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label">Propietario: </label>
                <label class="col-sm-3"><?php echo $equipo->getNomePropietario();?></label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Membros: </label>
                <label class="col-sm-1"><?php echo $equipo->getNumMembros();?></label>
            </div>
        </form>
    <?php
    }
    
    if($tab == "membros")
    {
        
    }
    
    if($tab == "torneos")
    {
        
    }
    
    if($tab == "editar")
    {
?>
        <form class="form-horizontal" role="form" id="formEditar" action="usuario.php" method="post">
        <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
        <fieldset id="fieldEditar">
        <legend><?php echo $user->getLogin();?></legend>             
         <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-4">
                  <input type="text" class="form-control" id="nome" name="nome" maxlength="50" value="<?php echo $user->getNome();?>" disabled required>
            </div>
          </div>
          <div class="form-group">
            <label for="contrasinal" class="col-sm-2 control-label">Contrasinal</label>
            <div class="col-sm-4">
                  <input type="password" class="form-control" id="contrasinal" name="contrasinal" maxlength="50" placeholder="Escribe un novo contrasinal" disabled required>
            </div>
         </div>
         <div class="form-group">
            <label class="col-sm-2 control-label">Equipo</label>
            <label class="col-sm-4 control-label">
                <?php
                    if($user->getNomeEquipo() != '')
                        echo "<a href='equipo.php?id=".$user->getIDEquipo() ."'>".$user->getNomeEquipo() ."</a>";
                    else
                        echo "Sen equipo";
                ?>
            </label>
         </div>
          <div class="form-group">                      
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" id="btnHabilitar" name="btnHabilitar" onClick="activarEdicionUsuario()"><span class='glyphicon glyphicon-edit'></span> Habilitar edici&oacute;n</button>    
                <button type="submit" class="btn btn-success" id="accion" name="accion" value="editar"  onClick="md5editar()" disabled style="visibility:hidden">Editar perfil</button>
            </div>
          </div>
                 
         </fieldset>
    </form>
        
<?php    
    }
    
    
            
            
?>
        </fieldset>
    

<?php

    }//else coñece id
?>

            
        </div>
    </div>

    
    
    
    



<?php include("footer.php"); ?>