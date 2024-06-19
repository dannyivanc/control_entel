<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Lista de Proyectos</span> 
      </div>

   </div>
   
   <div class="row">
      <?php 
      echo ('
        <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
              <div class="card-body">Entel</div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
              </div>
          </div>
      </div>');
      
      ?>

      
    
   </div>

<?php include "Views/Templates/footer.php";?>
<!-- <script src="<?php echo base_url;?>Assets/js/funciones_supervisiones.js"></script> -->

</body>
</html>
