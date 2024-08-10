<?php include "Views/Templates/header.php";?>

   <div class="card mb-4">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Instituciones</span> 
      </div>
   </div>
    <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmInstitucion();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>
 
   <table class="table  table-light table-bordered  custom-table " id="tblInstituciones">
         <thead class="thead-dark">
            <tr>  
               <th>Nº</th>
               <th>Institución</th>
               <th>Estado</th>
               <th>Acciones</th>                  
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 
   <div id="nuevo_institucion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="title">Nueva Institución</h5>
               <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
               </button>
            </div>
            <div class="modal-body">
               <form method="post" id="frmInstitucion" action="">            
               <input type="hidden"id="id" name="id">      
                  <div class="form-group">
                     <label for="institucion" class="mb-1">Institucion</label>
                     <input id="institucion" class="form-control" type="text" name="institucion" placeholder="Nombre de la Institución">
                  </div>
                  
                  <button id ="btn_form_institucion" class="btn btn-primary mt-3" type="button" onclick="registrarInstitucion(event);">
                     Registrar
                  </button>
                  <button class="btn btn-danger  mt-3" type="button" data-bs-dismiss="modal">
                     Cancelar
                  </button>
               </form>
            </div>
         
         </div>
      </div>
   </div>

<?php include "Views/Templates/footer.php";?>
<script src="<?php echo base_url;?>Assets/js/funciones_institucion.js"></script>

</body>
</html>
