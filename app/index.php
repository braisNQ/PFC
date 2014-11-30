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
            <li class="active"><a href="index.php">Inicio</a></li>
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
        <h1>Plataforma de xesti&oacute;n de torneos online</h1>
        <p>
        A idea deste proxecto xorde pola necesidade dun grupo de xente dedicada a organizar eventos e torneos
         de ter unha ferramenta acorde aos tempos actuais que lles permita realizar o seu traballo.
        </p>
        <p>
        Actualmente todo o proceso é manual, polo que é moi laborioso e complicado e pode dar lugar a erros. 
        Por isto, cómpre ter unha aplicación que realice todo o proceso de creación dos eventos dun xeito máis 
        sinxelo e eficaz.
        </p>
        <p>
        Preténdese con este proxecto poder crear unha infraestrutura capaz de informatizar todo o proceso de creación, 
        administración e desenvolvemento dos torneos e proporcionar os servizos necesarios para que mellore a experiencia 
        dos usuarios durante a súa estadía na páxina web, seguindo ao detalle os acontecementos, así como xestionando os mesmos.
        </p>
        <p>
        O código deste PFC estará dispoñible ao público baixo licenza GPL V3 (ou superior) no perfil de GitHub do autor cando estea rematado.
        </p>
        <p>
        <a class="btn btn-lg btn-primary" href="https://github.com/braisNQ/PFC" target="_blank" role="button">Ver en GitHub &raquo;</a>
        </p>
      </div>



  
    </div> <!-- /container -->
    
<?php include("footer.php"); ?>