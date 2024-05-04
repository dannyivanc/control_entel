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
        <script src="<?php echo base_url?>Assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="background">
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
                                <div class="card shadow-lg border-0 rounded-lg mt-1">
                                    <!-- <div class="card-header"><h3 class="text-center font-weight-light my-1">Autenticar</h3></div> -->
                                    <div class="card-body">
                                        <form id="frmLogin">
                                            <div class="form-group">
                                                <label class="small mb-1" for="usuario"><i class="fas fa-user"></i> Usuario</label>
                                                <input class="form-control py-4" id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="clave"><i class="fas fa-lock"></i> Contraseña</label>
                                                <input class="form-control py-4" id="clave" name="clave" type="password" placeholder="Ingrese su contraseña" />
                                            </div>       
                                             <div class="alert alert-danger text-center d-none" id="alerta" role="alert">
                                                
                                             </div>                                   
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">                                            
                                                <button class="btn btn-primary" type="submit" onclick="frmLogin(event);">Login</button>
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
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Said &copy; Todos los derechos reservados - 2024</div>
                            <!-- <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div> -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?php echo base_url?>Assets/js/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url?>Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url?>Assets/js/scripts.js"></script>
        <script>
            const base_url="<?php echo base_url; ?>";
        </script>
        <script src="<?php echo base_url?>Assets/js/funciones.js"></script>
    </body>
</html>
