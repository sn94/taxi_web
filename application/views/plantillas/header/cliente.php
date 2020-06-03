<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <a class="navbar-brand" href="#">TAXICARGAS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="true" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarColor01" style=""><!--sin show-->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a style="text-align: right;" class="nav-link" href="/taxiweb/welcome">INICIO <span class="sr-only">(current)</span></a>
        </li>
        <li style="text-align: right;"   class="nav-item dropdown">
        <a  class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <?=  $this->session->userdata("usuario") ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a  style="text-align: right;"  class="dropdown-item" href="#">Mi cuenta</a>
           <a  style="text-align: right;" class="dropdown-item" href="/taxi_web/cliente/pedidos_realizados">Pedidos realizados</a>
          <div class="dropdown-divider"></div>
          <a   style="text-align: right;"  class="dropdown-item" href="<?= base_url("usuario/sign_out")?>">Cerrar sesi&oacute;n</a>
        </div>
      </li>
      

       <li class="nav-item">
          <a  style="text-align: right;"  class="nav-link" href="<?= base_url("flete/add") ?>">Pedir taxicarga</a>
        </li>
 

      <li class="nav-item">
          <a  style="text-align: right;"  class="nav-link" href="#">NOSOTROS</a>
        </li>
      </ul>
     
    </div>
  </nav>

 