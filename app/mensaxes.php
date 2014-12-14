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
        <h4>Mensaxes</h4>
       
<?php
    //se non existe usuario logueado
    if(!isset($_SESSION['ID']))
    {
        aviso("danger", "Ups! non deberías estar aqu&iacute;.", "index.php", "Voltar ao Inicio");
    }
    //se está logueado
    else
    {
      /*
       * Variables default para o listado
       */
       $p = 1; //páxina listada
       $items = 10; //items listados por páxina
       $filtro="todas";
   
       /*
        * recoller variables
        */
       if (isset($_POST['p']))
          $p = $_POST['p'];     
       if (isset($_POST['items']))
          $items = $_POST['items']; 
       if (isset($_POST['filtro']))
          $filtro = $_POST['filtro'];

    
?>    
    <div class="panel panel-default">
        <div class="panel-heading text-right">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseForm">
                  Filtro <span class="caret"></span>
            </a>
        </div>
        <div id="collapseForm" class="panel-collapse collapse">
              <div class="panel-body">
                <form class="form-horizontal" role="form" id="formFiltro" action="mensaxes.php" method="post">
                    <input type="hidden" id="p" name="p" value="1">
                    <div class="form-group">
                        <div class="col-sm-5">
                          <label class="radio-inline control-label input-sm">
                              <input type="radio" name="filtro" id="filtroTodas" value="todas" <?php if($filtro == "todas") echo "checked";?>> Todas
                          </label>
                          <label class="radio-inline control-label input-sm">
                              <input type="radio" name="filtro" id="filtroVistas" value="vistas" <?php if($filtro == "vistas") echo "checked";?>> Vistas
                          </label>
                          <label class="radio-inline control-label input-sm">
                              <input type="radio" name="filtro" id="filtroNovas" value="novas" <?php if($filtro == "novas") echo "checked";?>> Novas
                          </label>
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
                             <a href="lista_equipos.php" class="btn btn-default btn-xs"><span class='glyphicon glyphicon-trash'></span> Limpar</a>
                        </div>
                      </div>
                </form>
              </div>
        </div>
    </div> 

<?php     
    
    $nt = $usuarioActual->numMensaxes();
    $nf = $usuarioActual->listarMensaxesCont($filtro);

    //calculos para paxinación
    $inicio = ($p - 1) * $items;
    $total_paxinas = ceil($nf / $items);
    
    $mostrando_inicio = intval($inicio +1);
    $mostrando_fin = intval($inicio + $items);
    
    if($mostrando_fin > $nf)
        $mostrando_fin = $mostrando_inicio + ($nf - $inicio -1);
    
    if($mostrando_inicio > $mostrando_fin)
        $mostrando_inicio = $mostrando_fin;
    
    $lista = $usuarioActual->listarMensaxes($filtro, $inicio, $items);
        
    echo "<span>Listando ".$mostrando_inicio." - ".$mostrando_fin." de ".intval($nf)." mensaxes filtrados.</span>";
    echo "<br />";
    echo "<span>Mensaxes totais: ".$nt."</span>";
    
    echo "
        <table class='table table-striped table-hover'>
            <tr>
                <th>Remitente</th>
                <th>Asunto</th>
                <th>Data</th>
                <th>Vista</th>
            </tr>
    ";

    if($lista->num_rows > 0)
    {
        while($row = $lista->fetch_assoc())
        {
            echo "<tr>";
                echo "<td>".$row['remitente']."</td>";    
                echo "<td><a href='mensaxe.php?id=".$row['ID']."'>".$row['asunto']."</a></td>";
                echo "<td>".$row['data']."</td>";
                echo "<td>";
                if($row['visto'] == 0)
                  echo "NON";
                else
                  echo "SI";
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



    }
?>
        
       
       
       
       
       
       
      </div>  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>