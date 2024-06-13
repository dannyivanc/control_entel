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
        <link href="<?php echo base_url?>Assets/css/style.min.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/DataTables/datatables.min.css" rel="stylesheet" crossorigin="anonymous">
        <script src="<?php echo base_url?>Assets/js/all.js" crossorigin="anonymous"></script>
    </head>
        
    <body class="sb-nav-fixed ">

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="height: 65px;">
            <a class="navbar-brand ms-3 mt-2" href="index.html" >
                <img src="<?php echo base_url?>/Assets/img/logo.png" class="logo_said_navbar " alt="logo">
                <span class="text-white-50  ms-3 ">Said</span>
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>  

            <ul class="navbar-nav ms-auto me-3 order-lg-1">
            <span class="my-custom-right text-white-50 mt-2 my-custom-none">
                   Usuario: <?php echo ($_SESSION['nombre']); ?>
            </span>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw "></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item"  href="<?php echo base_url;?>Perfil" onclick="frmPerfil();">Perfil</a></li>
                        <li><a class="dropdown-item"  href="<?php echo base_url;?>Usuarios/salir">Cerrar sesion</a></li>
                    </ul>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Usuarios
                            </a>
                          <!-- para instituciones -->

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-city"></i></div>
                                Instituciones
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <a class="nav-link ms-3" href="<?php echo base_url?>Instituciones"> 
                                    <div class="sb-nav-link-icon "><i class="fas fa-building"></i></div>
                                    Institución
                                </a>
                                <a class="nav-link ms-3" href="<?php echo base_url?>Sucursales">                                   
                                    <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                                    Sucursal
                                </a>
                            </div>    
                            <a class="nav-link " href="<?php echo base_url?>Vehiculos">                     
                                <div class="sb-nav-link-icon"><i class="fas fa-car-side"></i></div>
                                Vehiculos
                            </a>
                            <a class="nav-link " href="<?php echo base_url?>Materiales">                     
                                <div class="sb-nav-link-icon"><i class="fas fa-dolly"></i></div>
                                Materiales
                            </a>
                         
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid mt-4 pe-4 ps-4">
                 <main>
                  
                   
       