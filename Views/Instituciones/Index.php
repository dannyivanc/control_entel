<?php include "Views/Templates/header.php";?>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Instituciones</li>
   </ol>    
   <button class="btn btn-primary mb-2" type="button" onclick="frmInstitucion();">Nuevo   <i class="fas fa-plus"></i></button>  

   <table class="table  table-light custom-table " id="tblInstituciones">
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
               <button class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form method="post" id="frmInstitucion" action="">            
               <input type="hidden"id="id" name="id">      
                  <div class="form-group">
                     <label for="institucion">Institucion</label>
                     <input id="institucion" class="form-control" type="text" name="institucion" placeholder="Nombre de la Institución">
                  </div>
                  
                  <button id ="btn_form_institucion" class="btn btn-primary mt-3" type="button" onclick="registrarInstitucion(event);">
                     Registrar
                  </button>
                  <button class="btn btn-danger  mt-3" type="button" data-dismiss="modal">
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
