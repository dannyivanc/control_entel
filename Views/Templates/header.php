<!DOCTYPE html>
<html lang="es">
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
        <link href="<?php echo base_url?>Assets/scss/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="<?php echo base_url?>Assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- <img src="<?php echo base_url?>/Assets/img/logo.png" alt="logo"> -->
            <a class="navbar-brand " href="index.html">
                <img src="<?php echo base_url?>/Assets/img/logo.png" class="logo_said_navbar" alt="logo">
                Said
            </a>
            <button class="btn btn-link btn-sm order-0 " id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
      
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Perfil</a>
                        <!-- <a class="dropdown-item" href="#">Activity Log</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url;?>Usuarios/salir">Serrar sesiòn</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link ml-1" href="<?php echo base_url?>Usuarios"> 
                                <i class="fas fa-user mr-3"></i>
                                Usuarios
                            </a>
                            <!-- para instituciones -->
                            <a class="nav-link collapsed ml-1" href="#" data-toggle="collapse" data-target="#intitucionesLayouts" aria-expanded="false" aria-controls="intitucionesLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-city"></i></div>
                                    Instituciones
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="intitucionesLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <a class="nav-link ml-3" href="<?php echo base_url?>Instituciones"> 
                                    <i class="fas fa-building mr-2"></i>
                                    Institución
                                </a>
                                <a class="nav-link ml-3" href="<?php echo base_url?>Sucursales"> 
                                    <i class="fas fa-store mr-2"></i>
                                    Sucursal
                                </a>
                            </div>


                            <a class="nav-link ml-1" href="<?php echo base_url?>Vehiculos"> 
                                <i class="fas fa-car-side mr-2"></i>
                                Vehiculos
                            </a>


                            <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Instituciones
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div> -->

                      
                        </div>
                        
                    </div>

                    
                    <!-- <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div> -->
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid mt-3">
                        
                       
    