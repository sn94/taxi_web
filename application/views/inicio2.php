<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Inicio</title>
    	<meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 
Power Template 
http://www.templatemo.com/tm-508-power
-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="/taxi_web/assets/power_template/css/bootstrap.min.css">
        <link rel="stylesheet" href="/taxi_web/assets/power_template/css/font-awesome.css">
        <link rel="stylesheet" href="/taxi_web/assets/power_template/css/animate.css">
        <link rel="stylesheet" href="/taxi_web/assets/power_template/css/templatemo_misc.css">
        <link rel="stylesheet" href="/taxi_web/assets/power_template/css/templatemo_style.css">
        <link rel="stylesheet" href="/taxi_web/assets/power_template/css/owl-carousel.css">

        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>

        <style>
            .banner{
               
                background-image: url(assets/img/transporte.jpg) !important;
                background-size: cover;
            }
            .banner-content{
                padding-top: 50px;
            }
            .btn.btn-lg{ 
                color: #171702;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->


       

        <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="banner-content">
                          
                     
                        <img style="width: 100%;" class="img-responsive img-fluid mx-auto d-block" src="/taxi_web/assets/img/logo-taxicargascom.png" alt="">
                     
                            
                            <ul class="buttons">
                                <li>
                                <?php
                                if( $this->session->userdata("usuario") || $this->session->has_userdata("tipo") ){ ?>
                                <a href="proveedor/index" class="btn btn-lg btn-warning">BUSCAR</a>
                                <?php  }else{ ?>

                                <a href="welcome/sel_modo_ingreso/c" class="btn btn-lg btn-warning">BUSCAR</a>
                                
                                <?php } ?>
                
                                
                                </li>
                                <li>
                                <?php if( $this->session->userdata("usuario") || $this->session->has_userdata("tipo") ){ ?>
                                <a href="cliente/index" class="btn btn-lg btn-warning">OFRECER</a>
                                <?php  }else{ ?>

                                <a href="welcome/sel_modo_ingreso/p" class="btn btn-lg btn-warning">OFRECER</a>
                                
                                <?php } ?>
                                 
                                      
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         
        


       

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                            <p>Copyright &copy; 2017 Your Company <br> 
                            Power Theme by HTML5 Max</p>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <ul class="social-icons">
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Linkedin</a></li>
                            <li><a href="#">Instagram</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-md-offset-2 col-sm-12">
                        <div class="back-to-top">
                            <a href="#top">
                                <i class="fa fa-angle-up"></i>
                                back to top
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
        <script src="js/vendor/jquery-1.11.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Map -->
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="js/vendor/jquery.gmap3.min.js"></script>

        <script type="text/javascript">
        $(document).ready(function() {
            
            // mobile nav toggle
            $('#nav-toggle').on('click', function (event) {
                event.preventDefault();
                $('#main-nav').toggleClass("open");
            });
        });
        </script>
        
        <!-- templatemo 406 flex -->
    </body>
</html>