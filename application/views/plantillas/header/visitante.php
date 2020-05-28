<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">TAXICARGAS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="true" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse show" id="navbarColor01" style="">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/taxi_web/welcome">INICIO <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       VISITANTE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= base_url("usuario/create/c")?>">Registrarme como cliente</a>
          <a class="dropdown-item" href="<?= base_url("usuario/create/p")?>">Registrarme como proveedor</a>
           
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= base_url("usuario/sign_in")?>">Iniciar sesi&oacute;n</a>
        </div>
      </li>
       

       
 

      <li class="nav-item">
          <a class="nav-link" href="#">NOSOTROS</a>
        </li>
      </ul>
     
    </div>
  </nav>

 