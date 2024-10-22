<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de control para la empresa SAID"/>
        <meta name="author" content="" />
        <link rel="icon" href="<?php echo base_url?>/Assets/img/logo-min.png" type="image/x-icon">
        <title>Said:Seguridad Fisica & Electronica</title>
        <link href="<?php echo base_url?>Assets/css/custom.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/css/style.min.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/css/select2.min.css" rel="stylesheet" />
        <link href="<?php echo base_url?>Assets/DataTables/datatables.min.css" rel="stylesheet" crossorigin="anonymous">
        <script src="<?php echo base_url?>Assets/js/all.js" crossorigin="anonymous"></script>
    </head>
        
    <body class="sb-nav-fixed ">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="height: 65px;">
            <a class="navbar-brand ms-3 mt-2" href="<?php echo base_url;?>Inicio" >
                <img src="<?php echo base_url?>/Assets/img/logo.png" class="logo_said_navbar " alt="logo">
                <span class="text-white-50  ms-3 ">Said</span>
            </a>
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
                        <li><a class="dropdown-item"  href="<?php echo base_url;?>Perfil">Perfil</a></li>
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
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <?php if ($_SESSION['rol']!= "cliente") : ?>
                                <?php if (isset($_SESSION['v_1'])) : ?>
                                    <a class="nav-link ml-1" href="<?php echo base_url?>Usuarios"> 
                                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                        Usuarios
                                    </a> 
                                <?php endif; ?>

                                <?php if (isset($_SESSION['v_2'])||isset($_SESSION['v_3'])) : ?>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div class="sb-nav-link-icon"><i class="fas fa-city"></i></div>
                                        Instituciones
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                        <?php if (isset($_SESSION['v_2'])) : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Instituciones"> 
                                                <div class="sb-nav-link-icon "><i class="fas fa-building"></i></div>
                                                Institución
                                            </a>
                                        <?php endif; ?>                                   
                                        <?php if (isset($_SESSION['v_3'])) : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Sucursales">                                   
                                                <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                                                Sucursal
                                            </a>
                                        <?php endif; ?>
                                    </div>    
                                <?php endif; ?>
                      
                                <?php if (isset($_SESSION['v_4'])||isset($_SESSION['v_5'])) : ?>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#supervisores" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                                            Supervisores
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="supervisores" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                        <?php if (isset($_SESSION['v_4'])) : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=Supervision"> 
                                                <div class="sb-nav-link-icon "><i class="fas fa-bullseye"></i></div>
                                                Supervisión
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($_SESSION['v_5'])) : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=Patrullaje">                                   
                                                <div class="sb-nav-link-icon"><i class="fas fa-building-shield"></i></div>
                                                Patrullaje 
                                            </a>
                                        <?php endif; ?>                                   
                                    </div>                                         
                                <?php endif; ?>    
                                
                                <?php if ($_SESSION['rol']=='vigilante') : ?>
                                        <?php if (isset($_SESSION['v_6'])||isset($_SESSION['v_7'])||isset($_SESSION['v_8'])) : ?>
                                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#controles" aria-expanded="false" aria-controls="collapseLayouts">
                                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                                Controles
                                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                            </a>
                                            <div class="collapse" id="controles" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">       

                                            <?php if (isset($_SESSION['v_6'])) : ?>
                                                <a class="nav-link ms-3" href="<?php echo base_url?>Vehiculos">                     
                                                    <div class="sb-nav-link-icon"><i class="fas fa-car-side"></i></div>
                                                    Vehiculos
                                                </a>                                    
                                            <?php endif; ?>                                
                                            <?php if (isset($_SESSION['v_7'])) : ?>
                                                <a class="nav-link ms-3" href="<?php echo base_url?>Materiales">                     
                                                    <div class="sb-nav-link-icon"><i class="fas fa-dolly"></i></div>
                                                    Materiales
                                                </a>
                                            <?php endif;?>         
                                            <?php if (isset($_SESSION['v_8'])) : ?>
                                                <a class="nav-link ms-3" href="<?php echo base_url?>Visitas">                     
                                                    <div class="sb-nav-link-icon"><i class="fa-regular fa-address-card"></i></div>
                                                    Visitas
                                                </a>
                                            <?php endif;?>                                 
                                            </div>
                                        <?php endif;?>
                                <?php else : ?>                                    
                                        <?php if (isset($_SESSION['v_6'])||isset($_SESSION['v_7'])||isset($_SESSION['v_8'])) : ?>
                                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#controles" aria-expanded="false" aria-controls="collapseLayouts">
                                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                                Controles
                                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                            </a>
                                            <div class="collapse" id="controles" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">       
                                            <?php if (isset($_SESSION['v_6'])) : ?>
                                                <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=RegistroVehiculo">
                                                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                    Vehiculos
                                                </a>
                                            <?php endif; ?>                                
                                            <?php if (isset($_SESSION['v_7'])) : ?>
                                                <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=RegistroMaterial">
                                                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                    Materiales
                                                </a>
                                            <?php endif;?>   
                                            <?php if (isset($_SESSION['v_8'])) : ?>
                                                <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=RegistroVisita">
                                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-address-card"></i></div>
                                                    Visitas
                                                </a>
                                            <?php endif;?>                                                                           
                                            </div>
                                        <?php endif;?>                                           
                                <?php endif; ?> 
                            <?php endif; ?>
                          
                            <?php if ($_SESSION['rol']!='vigilante') : ?>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#reportes" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-column"></i></div>
                                        Reportes
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>                                
                                <div class="collapse" id="reportes" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                    <?php if (isset($_SESSION['v_20'])) : ?>
                                        <a class="nav-link ms-3" href="<?php echo base_url?>ReporteVigilantes">                     
                                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                            Vigilantes
                                        </a>
                                    <?php endif; ?>   
                                    <?php if (isset($_SESSION['v_21'])) : ?>
                                        <a class="nav-link ms-3" href="<?php echo base_url?>ReporteSupervisiones">                     
                                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                            Supervisión
                                        </a>
                                    <?php endif; ?>                               

                                    <?php if (isset($_SESSION['v_22'])) : ?>
                                        <a class="nav-link ms-3" href="<?php echo base_url?>ReportePatrullajes">                     
                                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                            Patrullaje
                                        </a>   
                                    <?php endif; ?>  

                                    <?php if (isset($_SESSION['v_23'])) : ?>
                                        <?php if ($_SESSION['rol']=='cliente') : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>ProyectoSucursal?view=ReporteVehiculos&id=<?php echo ($_SESSION['id_institucion'])?>">
                                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                Vehiculos
                                            </a>
                                        <?php else : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=ReporteVehiculos">
                                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                Vehiculos
                                            </a>
                                        <?php endif; ?> 
                                    <?php endif; ?>  
                            
                                    <?php if (isset($_SESSION['v_24'])) : ?>
                                        <?php if ($_SESSION['rol']=='cliente') : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>ProyectoSucursal?view=ReporteMateriales&id=<?php echo ($_SESSION['id_institucion'])?>">
                                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                Materiales
                                            </a>
                                        <?php else : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=ReporteMateriales">
                                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                Materiales
                                            </a>
                                        <?php endif; ?> 
                                    <?php endif; ?>  

                                    <?php if (isset($_SESSION['v_25'])) : ?>
                                        <?php if ($_SESSION['rol']=='cliente') : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>ProyectoSucursal?view=ReporteVisitas&id=<?php echo ($_SESSION['id_institucion'])?>">
                                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                Visitas
                                            </a>
                                        <?php else : ?>
                                            <a class="nav-link ms-3" href="<?php echo base_url?>Proyectos?view=ReporteVisitas">
                                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                                                Visitas
                                            </a>
                                        <?php endif; ?> 
                                    <?php endif; ?>  
                                    <div id="miDiv" style="display: none;">
                                    </div>
                                </div> 
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid mt-4 pe-4 ps-4">
                <main>
                  
                   
       