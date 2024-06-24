<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Lista de Proyectos</span> 
      </div>
   </div>
   <div class="row">
      <?php
         $colors = ["bg-primary", "bg-secondary", "bg-success", "bg-danger", "bg-info", "bg-dark"];
         $colorIndex = 0;
      ?> 
      <?php foreach ($data as $institucion): ?>
         <div class="col-xl-3 col-md-6" onclick="viewInstitucion('<?php echo $institucion['id']?>','<?php echo $institucion['institucion']?>')">
            <div class="card <?php echo $colors[$colorIndex]; ?> text-white mb-4 align-middle">
                  <div class="card-body text-center fs-3"> 
                     <?php echo $institucion["institucion"]; ?>
                  </div>
            </div>
         </div>
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
