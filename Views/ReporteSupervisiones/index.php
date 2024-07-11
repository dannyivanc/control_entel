<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Supervisiones</span> 
      </div>
   </div>
   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="descargarPdf();">
         Descargar <i class="fas fa-file-pdf"></i>
      </button>
   </div>
         
   <table class="table  table-light table-bordered custom-table" id="tblRepSupervisiones">
       <thead class="thead-dark">
               <tr>
                  <th>Nº</th>  
                  <th>Fecha</th>
                  <th>Sucursal</th>
                  <th>Vigilante</th>
                  <th>Puntualidad</th>
                  <th>Pres. Pers.</th>  
                  <th>Patrulla</th>  
                  <th>Epp</th>
                  <th>Libro</th>  
                  <th>Verif. Vehi.</th>  
                  <!-- <th>Ver ubicacion</th> -->
               </tr>           
         </thead>
   </table>    
<?php include "Views/Templates/footer.php";?>

<script src="<?php echo base_url;?>Assets/js/funciones_reporte_supervisiones.js"></script>
</body>
</html>
