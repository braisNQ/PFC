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
        <h4>Usuarios</h4>
        
<?php

    /*
     * Variables default para o listado
     */
     $p = 1; //páxina listada
     
     $items = 10; //items listados por páxina
     $orderby = "login";
     $order = "asc"; //orden de listado
     $enequipo = 0; // 0-todos, 1-sen equipo, 2-con equipo
     $login='';
     $nome='';
     $tipo= 0;
 
     /*
      * recoller variables
      */
     if (isset($_POST['p']))
        $p = $_POST['p'];     
     if (isset($_POST['items']))
        $items = $_POST['items'];
     if (isset($_POST['orderby']))
        $orderby = $_POST['orderby'];     
     if (isset($_POST['order']))
        $order = $_POST['order'];     
     if (isset($_POST['enequipo']))
        $enequipo = $_POST['enequipo'];
     if (isset($_POST['login']))
        $login = $_POST['login'];
     if (isset($_POST['nome']))
        $nome = $_POST['nome'];
     if (isset($_POST['tipo']))
        $tipo = $_POST['tipo'];

     /*
     echo "p: ".$p."<br>";
     echo "items: ".$items."<br>";
     echo "orderby: ".$orderby."<br>";
     echo "order: ".$order."<br>";
     echo "enequipo: ".$enequipo."<br>";
     echo "login: ".$login."<br>";
     echo "nome: ".$nome."<br>";
     echo "tipo: ".$tipo."<br>";
      * 
      */
    
?>    
    <div class="panel panel-default">
        <div class="panel-heading text-right">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseForm">
                  Filtro <span class="caret"></span>
            </a>
        </div>
        <div id="collapseForm" class="panel-collapse collapse">
              <div class="panel-body">
                <form class="form-horizontal" role="form" id="formFiltro" action="lista_usuarios.php" method="post">
                    <input type="hidden" id="p" name="p" value="1">
                    <div class="form-group">
                        <label for="login" class="col-sm-1 control-label input-sm">Login</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" id="login" name="login" maxlength="50" value="<?php echo $login;?>">
                        </div>
                        <label for="nome" class="col-sm-1 control-label input-sm">Nome</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" id="nome" name="nome" maxlength="50" value="<?php echo $nome;?>">
                        </div>
                        <label for="tipo" class="col-sm-1 control-label input-sm">Nivel</label>
                        <div class="col-sm-2">
                            <select class="form-control input-sm" name="tipo" id="tipo">
                              <option value="0" <?php if($tipo == 0) echo "selected";?>>Tod@s</option>
                              <option value="1" <?php if($tipo == 1) echo "selected";?>>Administrador/a</option>
                              <option value="2" <?php if($tipo == 2) echo "selected";?>>Moderador/a</option>
                              <option value="3" <?php if($tipo == 3) echo "selected";?>>Usuaria/o</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="enquipo" class="col-sm-1 control-label input-sm">Equipo</label>
                        <div class="col-sm-2">
                            <select class="form-control input-sm" name="enequipo" id="enequipo">
                              <option value="0" <?php if($enequipo == 0) echo "selected";?>>Tod@s</option>
                              <option value="1" <?php if($enequipo == 1) echo "selected";?>>Sen equipo</option>
                              <option value="2" <?php if($enequipo == 2) echo "selected";?>>Con equipo</option>
                            </select>
                        </div>
                        <label for="orderby" class="col-sm-1 control-label input-sm">Orde</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <select class="form-control input-sm" name="orderby" id="orderby">
                                  <option value="login" <?php if($orderby == "login") echo "selected";?>>Login</option>
                                  <option value="nome" <?php if($orderby == "nome") echo "selected";?>>Nome</option>
                                </select>
                                &nbsp;&nbsp;
                                <label class="radio-inline control-label input-sm">
                                      <input type="radio" name="order" id="orderAsc" value="asc" <?php if($order == "asc") echo "checked";?>> A-Z</span> <span class="caret"></span>
                                </label>
                                <label class="radio-inline control-label input-sm">
                                  <input type="radio" name="order" id="orderDesc" value="desc" <?php if($order == "desc") echo "checked";?>> Z-A</span> <span class="caret caret-reversed"></span>
                                </label>
                            </div>
                        </div>
                        <label for="items" class="col-sm-2 control-label input-sm">Resultados por p&aacute;xina</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control input-sm" id="items" name="items" min="1" max="20" step="1" value="<?php echo $items;?>" required>
                        </div>                        
                      </div>
                    <div class="form-group">                        
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2">
                             <button type="submit" class="btn btn-info btn-xs" name="accion" value="filtrar"><span class='glyphicon glyphicon-search'></span> Filtrar</button> 
                             <a href="lista_usuarios.php" class="btn btn-default btn-xs"><span class='glyphicon glyphicon-trash'></span> Limpar</a>
                        </div>
                      </div>
                </form>
              </div>
        </div>
    </div> 

<?php     

    $bd = new bd();
    
    $nt = $bd->numeroUsuarios();
    $nf = $bd->listarUsuariosCont($login, $nome, $enequipo, $tipo);

    //calculos para paxinación
    $inicio = ($p - 1) * $items;
    $total_paxinas = ceil($nf / $items);
    
    $mostrando_inicio = intval($inicio +1);
    $mostrando_fin = intval($inicio + $items);
    
    if($mostrando_fin > $nf)
        $mostrando_fin = $mostrando_inicio + ($nf - $inicio -1);
    
    if($mostrando_inicio > $mostrando_fin)
        $mostrando_inicio = $mostrando_fin;
    
    $lista = $bd->listarUsuarios($login, $nome, $enequipo, $tipo, $orderby, $order, $inicio, $items);
        
    echo "<span>Listando ".$mostrando_inicio." - ".$mostrando_fin." de ".intval($nf)." usuarios filtrados.</span>";
    echo "<br />";
    echo "<span>Usuarios totais: ".$nt."</span>";
    
    echo "
        <table class='table table-striped table-hover'>
            <tr>
                <th>Login</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Equipo</th>
                <th>&nbsp;</th>
            </tr>
    ";

    if($lista->num_rows > 0)
    {
        while($row = $lista->fetch_assoc())
        {
            echo "<tr>";
                echo "<td>".$row['login']."</td>";
                echo "<td>".$row['nome']."</td>";
                echo "<td>";
                    if ($row['tipo'] == 1) echo "Administrador/a";
                    if ($row['tipo'] == 2) echo "Moderador/a";
                    if ($row['tipo'] == 3) echo "Usuaria/o";
                echo "</td>";
                echo "<td><a href='equipo.php?id=".$row['ID_equipo']."'>".$row['nomeequipo']."</a></td>";                
                
                echo "<td>";
                    if(isset($_SESSION['ID']))
                    {
                        if($row['ID'] != $_SESSION['ID'])
                            echo "<a class='btn btn-default btn-xs' href='mensaxe_send.php?id=".$row['ID']."'><span class='glyphicon glyphicon-envelope' data-toggle='tooltip' data-placement='top' title='Enviar mensaxe'></span></a> ";
                        if(($row['ID'] == $_SESSION['ID']) || $usuarioActual->admin())
                            echo "<a class='btn btn-info btn-xs' href='usuario.php?id=".$row['ID']."'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Editar perfil'></span></a> ";
                        if($usuarioActual->admin())
                            echo "<a class='btn btn-danger btn-xs' href='usuario_delete.php?id=".$row['ID']."'><span class='glyphicon glyphicon-remove-sign' data-toggle='tooltip' data-placement='top' title='Eliminar usuario'></span></a> ";
                    }
                    
                echo "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
    
    //creando paxinación
    echo "        <ul class='pagination'>";
    if($p == 1)
    {
        echo "      <li class='disabled'><a href='#'>&laquo;</a></li>";
        echo "      <li class='disabled'><a href='#'>&lt;</a></li>";
    }
    else
    {
        echo "      <li><a href='#' onClick='cambiaPaxListado(1)'>&laquo;</a></li>";
        echo "      <li><a href='#' onClick='cambiaPaxListado(".intval($p -1).")'>&lt;</a></li>";
    }
        
    for($i=1; $i<=$total_paxinas; $i++)
    {
        if($i == $p)
            echo "<li class='active'><a href='#'>".$i."</a></li>";
        else
            echo "<li><a href='#' onClick='cambiaPaxListado(".$i.")'>".$i."</a></li>";
    }
    if($p >= $total_paxinas)
    {
        echo "          <li class='disabled'><a href='#'>&gt;</a></li>";
        echo "          <li class='disabled'><a href='#'>&raquo;</a></li>";        
    }
    else
    {
        echo "      <li><a href='#' onClick='cambiaPaxListado(".intval($p + 1).")'>&gt;</a></li>";
        echo "      <li><a href='#' onClick='cambiaPaxListado(".intval($total_paxinas).")'>&raquo;</a></li>";        
    }
    echo "        </ul>";
?>
        
      



        </div> <!--jumbotron -->
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>