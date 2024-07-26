<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <h2 class="text-black-75 fs-5">Lista de Proyectos</h2> 
         <?php
         $title='';
         switch ($data['vista']){
            case "Supervision":
               $title='Superviciones';
               break;
            case "Patrullaje":
               $title='Patrullaje';
               break;
            case "ReporteSupervision":
               $title='Reporte de Superviciones';
               break;
            case "ReportePatrullajes":
               $title='Reporte de Patrullajes';
               break;
            case "ReporteVehiculos":
               $title='Reporte de entrada y salida de Vehiculos';
               break; 
         }
         ?> 

         <h2 class="text-black-75 fs-6"><?php echo $title?></h2>
         <div>
      
         </div>
      </div>
   </div>
   <div class="row">
      <?php
         $colors = ["bg-primary", "bg-secondary", "bg-success", "bg-danger", "bg-info", "bg-dark"];
         $colorIndex = 0;
         $view=$data['vista'];
      ?> 
      <?php foreach ($data['instituciones'] as $institucion): ?>
         <?php
            if ( $view == 'Supervision' ||  $view == 'Patrullaje') {
         ?>
         <div class="col-xl-3 col-md-6" onclick="viewInstitucion('<?php echo $institucion['id']?>','<?php echo $data['vista']?>')">
               <div class="card <?php echo $colors[$colorIndex]; ?> text-white mb-4 align-middle">
                  <div class="card-body text-center fs-3"> 
                     <?php echo $institucion["institucion"]; ?>
                  </div>
               </div>
         </div>
         <?php
            } else if ($view == 'ReporteVigilantes' || $view == 'ReporteSupervision') {
         ?>
         <div class="col-xl-3 col-md-6" onclick="viewInstitucion('<?php echo $institucion['id']?>','<?php echo $data['vista']?>')">
               <div class="card <?php echo $colors[$colorIndex]; ?> text-white mb-4 align-middle">
                     <div class="card-body text-center fs-3"> 
                        <?php echo $institucion["institucion"]; ?>
                     </div>
               </div>
            </div>
         <?php
             } else if ($view == 'ReporteVehiculos') {
         ?>
         <a style="text-decoration: none;" class="col-xl-3 col-md-6" href="<?php echo base_url?>ProyectoSucursal?view=<?php echo $data['vista']?>&id=<?php echo $institucion['id']?>">
               <div class="card <?php echo $colors[$colorIndex]; ?> text-white mb-4 align-middle">
                  <div class="card-body text-center fs-3"> 
                     <?php echo $institucion["institucion"]; ?>
                  </div>
               </div>
         </a>
         <?php
            }
         ?>
         <?php
            $colorIndex++;
            if ($colorIndex >= count($colors)) {
               $colorIndex = 0;
            }
         ?>



         
      <?php endforeach; ?>


   </div>

<?php include "Views/Templates/footer.php";?>
<script src="<?php echo base_url;?>Assets/js/funciones_proyecto.js"></script>
</body>
</html>
