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
        <h4>Torneos</h4>
       
<?php

    if(isset($_SESSION['ID']) && $usuarioActual->admin())
    {
        echo '
            <div class="alert alert-info" role="alert">
                <div class="text-center">            
                    <a href="torneo_create.php" class="btn btn-success">Novo torneo</a>
                </div>
            </div>
        ';
    }

    /*
     * Variables default para o listado
     */
     $p = 1; //páxina listada
     
     $items = 10; //items listados por páxina
     $orderby = "nome";
     $order = "asc"; //orden de listado
     $nome='';

     $iniciado = -1;
 
     /*
      * recoller variables
      */
     if (isset($_POST['p']))
        $p = $_POST['p'];     
     if (isset($_POST['items']))
        $items = $_POST['items']; 
     if (isset($_POST['order']))
        $order = $_POST['order'];
     if (isset($_POST['nome']))
        $nome = $_POST['nome'];
     if (isset($_POST['iniciado']))
        $iniciado = $_POST['iniciado'];

    
?>    
    <div class="panel panel-default">
        <div class="panel-heading text-right">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseForm">
                  Filtro <span class="caret"></span>
            </a>
        </div>
        <div id="collapseForm" class="panel-collapse collapse">
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="formFiltro" action="lista_torneos.php" method="post">
                    <input type="hidden" id="p" name="p" value="1">
                    <div class="form-group">
                        <label for="nome" class="col-sm-1 control-label input-sm">Nome</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm" id="nome" name="nome" maxlength="50" value="<?php echo $nome;?>">
                        </div>
                           <div class="col-sm-2">
                            <label class="radio-inline control-label input-sm">
                                <input type="radio" name="order" id="orderAsc" value="asc" <?php if($order == "asc") echo "checked";?>> A-Z</span> <span class="caret"></span>
                            </label>
                            <label class="radio-inline control-label input-sm">
                                <input type="radio" name="order" id="orderDesc" value="desc" <?php if($order == "desc") echo "checked";?>> Z-A</span> <span class="caret caret-reversed"></span>
                            </label>
                        </div>
                        <label for="items" class="col-sm-2 control-label input-sm">Resultados por p&aacute;xina</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control input-sm" id="items" name="items" min="1" max="20" step="1" value="<?php echo $items;?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo" class="col-sm-1 control-label input-sm">Estado</label>
                        <div class="col-sm-2">
                            <select class="form-control input-sm" name="iniciado" id="iniciado">
                              <option value="-1" <?php if($iniciado == -1) echo "selected";?>>Todos</option>
                              <option value="0" <?php if($iniciado == 0) echo "selected";?>>Sen comezar</option>
                              <option value="1" <?php if($iniciado == 1) echo "selected";?>>Comezados</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">                        
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2">
                             <button type="submit" class="btn btn-info btn-xs" name="accion" value="filtrar"><span class='glyphicon glyphicon-search'></span> Filtrar</button> 
                             <a href="lista_torneos.php" class="btn btn-default btn-xs"><span class='glyphicon glyphicon-trash'></span> Limpar</a>
                        </div>
                     </div>
                </form>
            </div>
        </div>
    </div> 

<?php     

    $bd = new bd();
    
    $nt = $bd->numeroTorneos();
    $nf = $bd->listarTorneosCont($nome, $iniciado);

    //calculos para paxinación
    $inicio = ($p - 1) * $items;
    $total_paxinas = ceil($nf / $items);
    
    $mostrando_inicio = intval($inicio +1);
    $mostrando_fin = intval($inicio + $items);
    
    if($mostrando_fin > $nf)
        $mostrando_fin = $mostrando_inicio + ($nf - $inicio -1);
    
    if($mostrando_inicio > $mostrando_fin)
        $mostrando_inicio = $mostrando_fin;
    
    $lista = $bd->listarTorneos($nome, $iniciado, $order, $inicio, $items);
        
    echo "<span>Listando ".$mostrando_inicio." - ".$mostrando_fin." de ".intval($nf)." torneos filtrados.</span>";
    echo "<br />";
    echo "<span>Torneos totais: ".$nt."</span>";
    
    echo "
        <table class='table table-striped table-hover'>
            <tr>
                <th>Nome</th>
                <th>Nº Equipos</th>
                <th>Estado</th>
                <th>Partidos Restantes</th>
                <th>&nbsp;</th>
            </tr>
    ";

    if($lista->num_rows > 0)
    {
        while($row = $lista->fetch_assoc())
        {
            echo "<tr>";
                echo "<td><a href='torneo.php?id=".$row['ID']."'>".$row['nome']."</a></td>";    
                echo "<td><a href='torneo.php?id=".$row['ID']."'>".$row['equipos']."</a></td>"; 
                echo "<td>";
                if ($row['iniciado'] == 0)
                    echo "Sen comezar";
                if ($row['iniciado'] == 1)
                    echo "Comezado";
                echo "</td>";
                echo "<td>".$row['pendentes']."</td>";    
                echo "<td>";

                if(isset($_SESSION['ID']))
                {
                    //se usuario é capitá,
                    //equipo non está en torneo
                    //torneo non está iniciado
                    if($usuarioActual->capitan() && $row['iniciado'] == 0 && !$usuarioActual->enTorneo($row['ID']))
                    {
                        echo "<a class='btn btn-success btn-xs' href='torneo_join.php?id=".$row['ID']."'><span class='glyphicon glyphicon-ok-sign' data-toggle='tooltip' data-placement='top' title='Inscribirse en torneo'></span></a> ";
                    }
                    
                    if($usuarioActual->modTorneo($row['ID']) || $usuarioActual->admin())
                    {
                        echo "<a class='btn btn-info btn-xs' href='torneo.php?id=".$row['ID']."&tab=editar'><span class='glyphicon glyphicon-edit' data-toggle='tooltip' data-placement='top' title='Editar torneo'></span></a> ";
                        echo "<a class='btn btn-danger btn-xs' href='torneo_delete.php?id=".$row['ID']."'><span class='glyphicon glyphicon-remove-sign' data-toggle='tooltip' data-placement='top' title='Eliminar torneo'></span></a> ";
                    }
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
        
       
       
       
       
       
       
      </div>  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>