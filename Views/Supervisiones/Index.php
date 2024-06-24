<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Supervisión de Proyectos</span> 
      </div>
   </div>

   <h1>Detalles de la Institución</h1>
    <p>ID: <?php echo $data['institucion']['id']; ?></p>
    <p>Nombre: <?php echo $data['institucion']['institucion']; ?></p>
    <!-- <p>Descripción: <?php echo $data['institucion']['descripcion']; ?></p> -->
    <!-- Otros detalles -->

  


<?php include "Views/Templates/footer.php";?>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArnsC-St34MYG-ZWpAlcwl6r0k_mLZMbA"></script> -->
<script src="<?php echo base_url;?>Assets/js/funciones_supervision.js"></script>

</body>
</html>
