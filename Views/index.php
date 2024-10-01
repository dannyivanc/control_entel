<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="<?php echo base_url?>/Assets/img/logo-min.png" type="image/x-icon">
        <title>Said</title>
        <link href="<?php echo base_url?>Assets/css/custom.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/css/styles.css" rel="stylesheet" />

        <link href="<?php echo base_url?>Assets/css/custom2.css" rel="stylesheet"/>
        <link href="<?php echo base_url?>Assets/css/style.css" rel="stylesheet">
        <script src="<?php echo base_url?>Assets/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body  class="background"">
        <div class="container-fluid position-relative p-0">
            <nav class="bounce-in-top navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="https://www.saidbolivia.com.bo/" class="navbar-brand p-0">
                    <div class="header-link-cont">
                        <img class="mt-1" src="<?php echo base_url?>Assets/img/logo2.png" alt="SAID">                        
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                    <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                <span>
                                    Empresa <i class="fa-solid fa-caret-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu m-0">
                                <a href="https://www.saidbolivia.com.bo/quien" class="dropdown-item">¿Quienes Somos?</a>
                                <a href="https://www.saidbolivia.com.bo/ubicaciones" class="dropdown-item">Ubicaciones</a>
                                <a href="https://www.saidbolivia.com.bo/certificacion" class="dropdown-item">Licencias</a>
                                <a href="https://www.saidbolivia.com.bo/clientes" class="dropdown-item">Clientes</a>
                                <a href="https://www.saidbolivia.com.bo/epp" class="dropdown-item">Epp</a>
                            </div>
                        </div>                       
                        <a href="https://www.saidbolivia.com.bo/organigrama" class="nav-item nav-link">Organizacion</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                <span>
                                    Servicios <i class="fa-solid fa-caret-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu m-0">
                                <a href="https://www.saidbolivia.com.bo/fisica" class="dropdown-item">Vigilancia Fisica</a>
                                <a href="https://www.saidbolivia.com.bo/proteccion" class="dropdown-item">Proteccion Personal</a>
                                <a href="https://www.saidbolivia.com.bo/eventos" class="dropdown-item">Seguridad de Eventos</a>
                                <a href="https://www.saidbolivia.com.bo/electronica" class="dropdown-item">Seguridad Electronica</a>
                                <a href="https://www.saidbolivia.com.bo/monitoreo" class="dropdown-item">Monitoreo de Camaras y Respuesta con Patrulla</a>
                            </div>
                        </div>
                        <a href="https://www.saidbolivia.com.bo/said" class="nav-item nav-link">Correspondencia</a>
                        <a href="https://www.saidbolivia.com.bo/credenciales" class="nav-item nav-link">Control de Credenciales</a>
                        <a href="https://www.samibolivia.com.bo/control" class="nav-item nav-link">Seguimiento</a>
                    </div>                 
                </div>
            </nav>
        </div>
 
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="login-said">
                            <img class="login-said_img" src="<?php echo base_url?>/Assets/img/logo.png" alt="said">
                            <h2 class="login-said_t1">SAID</h2>
                            <div class="login-said_seg">
                                <h2 class="login-said_t2">SEGURIDAD FISICA</h2>
                                <h2 class="login-said_t2">&</h2>
                                <h2 class="login-said_t2">ELECTRONICA</h2>
                            </div>                               
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-3">
                                    <div class="card-header bg-dark"><h3 class="text-center font-weight-light my-1 text-white ">Autenticar</h3></div>
                                    <div class="card-body">
                                        <form id="frmLogin" onsubmit="frmLogin(event);">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario" />
                                                <label for="usuario"> <i class="fas fa-user"></i> Usuario</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="clave" name="clave" type="password" placeholder="Ingrese su contraseña" />
                                                <label for="clave"><i class="fas fa-lock"></i> Contraseña</label>
                                            </div>
                                            <div class="alert alert-danger text-center d-none" id="alerta" role="alert"> 
                                            </div>  
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">                                            
                                                <button class="btn btn-primary" type="submit" >Iniciar Sesion</button>
                                            </div>
                                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-3 bg-dark mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Said &copy; Todos los derechos reservados - 2024</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?php echo base_url?>Assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url?>Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url?>Assets/js/scripts.js"></script>
        <script>
            const base_url="<?php echo base_url; ?>";
        </script>
        <script src="<?php echo base_url?>Assets/js/login.js"></script>

    </body>
</html>
