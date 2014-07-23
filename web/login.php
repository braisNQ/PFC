			<li><a href="mensaxes.php"><?php echo md5("casa");?>Mensaxes  <span class="badge">42</span></a></li>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ola X!<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><a href="logout.php">O menu perfil</a></li>
                <li><a href="#">O meu equipo</a></li>
                <li class="divider"></li>
                <li class="dropdown-header"><a href="logout.php"><span class="glyphicon glyphicon-off btn-xs"></span> Pechar sesi&oacute;n</a></li>
              </ul>
            </li>

			<li><a href="#" data-toggle="modal" data-target="#loginModal">Login / Rexistro</a></li>
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
					<form class="form-horizontal" role="form" id="formLogin">						
					  <div class="form-group">
					    <label for="inputLogin" class="col-sm-2 control-label">Login</label>
					    <div class="col-sm-10">
					    	<div class="input-group">
							  <span class="input-group-addon glyphicon glyphicon-user"></span>
					      		<input type="text" class="form-control" id="inputLogin" placeholder="Login" required>
							</div>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputContrasinal" class="col-sm-2 control-label">Contrasinal</label>
					    <div class="col-sm-10">
					    	<div class="input-group">
							  <span class="input-group-addon glyphicon glyphicon-lock"></span>
					      		<input type="password" class="form-control" id="inputContrasinal" placeholder="Contrasinal" required>
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
					<form class="form-horizontal" role="form" id="tab">
						<div class="form-group">
					    <label for="inputLoginRexistro" class="col-sm-2 control-label">Login</label>
					    <div class="col-sm-10">
					    	<div class="input-group">
							  <span class="input-group-addon glyphicon glyphicon-user"></span>
					      		<input type="text" class="form-control" id="inputLoginRexistro" placeholder="Login" required>
							</div>
					    </div>
					  </div>
					   <div class="form-group">
					    <label for="inputContrasinalRexistro" class="col-sm-2 control-label">Contrasinal</label>
					    <div class="col-sm-10">
					    	<div class="input-group">
							  <span class="input-group-addon glyphicon glyphicon-lock"></span>
					      		<input type="password" class="form-control" id="inputContrasinalRexistro" placeholder="Contrasinal" required>
							</div>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputNomeRexistro" class="col-sm-2 control-label">Nome</label>
					    <div class="col-sm-10">
					    	<div class="input-group">
							  <span class="input-group-addon glyphicon glyphicon-comment"></span>
					      		<input type="text" class="form-control" id="inputNomeRexistro" placeholder="Nome a amosar" required>
							</div>
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					      <button type="submit" class="btn btn-primary">Crear conta</button>
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