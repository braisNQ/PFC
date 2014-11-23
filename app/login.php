<?php
    if (isset($_SESSION['ID']))
    {
        ?>
        <li><a href="mensaxes.php">Mensaxes <span class="badge"><?php echo $usuarioActual->mensaxesNovas();?></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "Ola ". $usuarioActual->getNome()."!"?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="usuario.php?id=<?php echo $_SESSION['ID']; ?>">O meu perfil</a></li>
<?php
if($usuarioActual->getIDequipo())
    echo '<li><a href="equipo.php?id='.$usuarioActual->getIDequipo().'">O meu equipo</a></li>';
else
    echo '<li><a href="equipo.php">O meu equipo</a></li>';
?>
            <li class="divider"></li>
            <li class="dropdown-header"><a href="logout.php"><span class="glyphicon glyphicon-off btn-xs"></span> Pechar sesi&oacute;n</a></li>
          </ul>
        </li>
        <?php
    }
    else
    {
        ?>
        <li><a href="#" data-toggle="modal" data-target="#loginModal">Login / Rexistro</a></li>
        <?php
    }
?>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Benvid@</h4>
      </div>
      <div class="modal-body">
      <br />
          <div class="well">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                <li><a href="#create" data-toggle="tab">Crear nova conta</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="login">
                    <br />
                    <form class="form-horizontal" role="form" id="formLogin" action="accesosistema.php" method="post">                        
                      <div class="form-group">
                        <label for="inputLogin" class="col-sm-2 control-label">Login</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon glyphicon glyphicon-user"></span>
                                  <input type="text" class="form-control" id="inputLogin" name="inputLogin" maxlength="50" placeholder="Login" required>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputContrasinal" class="col-sm-2 control-label">Contrasinal</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon glyphicon glyphicon-lock"></span>
                                  <input type="password" class="form-control" id="inputContrasinal" name="inputContrasinal" maxlength="50" placeholder="Contrasinal" required>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success" name="accion" value="login" onClick="md5login()">Entrar</button>
                        </div>
                      </div>
                    </form>            
                </div>
                <div class="tab-pane fade" id="create">
                    <br />                    
                    <form class="form-horizontal" role="form" id="formRexistro" action="accesosistema.php" method="post">
                        <div class="form-group">
                        <label for="inputLoginRexistro" class="col-sm-2 control-label">Login</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon glyphicon glyphicon-user"></span>
                                  <input type="text" class="form-control" id="inputLoginRexistro" name="inputLoginRexistro" maxlength="50" placeholder="Login" required>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputNomeRexistro" class="col-sm-2 control-label">Nome</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon glyphicon glyphicon-comment"></span>
                                  <input type="text" class="form-control" id="inputNomeRexistro" name="inputNomeRexistro" maxlength="50" placeholder="Nome a amosar" required>
                            </div>
                        </div>
                      </div>
                       <div class="form-group">
                        <label for="inputContrasinalRexistro" class="col-sm-2 control-label">Contrasinal</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                              <span class="input-group-addon glyphicon glyphicon-lock"></span>
                                  <input type="password" class="form-control" id="inputContrasinalRexistro" name="inputContrasinalRexistro" maxlength="50" placeholder="Contrasinal" required>
                            </div>
                        </div>
                      </div>                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-primary" name="accion" value="rexistro" onClick="md5rexistro()">Crear conta</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
          </div>
      <div class="modal-footer">&nbsp;</div>
    </div>
  </div>
</div>


</div>