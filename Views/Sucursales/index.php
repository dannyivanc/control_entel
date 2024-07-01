<?php include "Views/Templates/header.php";?>
<div class="card mb-4">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Sucursales</span> 
      </div>
   </div>

   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmSucursal();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>

   <table class="table  table-light table-bordered custom-table " id="tblSucursales">
         <thead class="thead-dark">
            <tr>  
               <th>Nº</th>             
               <th>Sucursal</th>
               <th>Institución</th>
               <th>Vigilante</th>
               <th>Ciudad</th>
               <th>Direccion</th> 
               <th>Estado</th>     
               <th>Acciones</th>                  
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 
   <div id="nuevo_sucursal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="title">Nueva Sucursal</h5>
               <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
               </button>
            </div>
               
            <div class="modal-body">
               <form method="post" id="frmSucursal" action="">            
               <input type="hidden"id="id" name="id">  
                  <div class="form-group">
                     <label for="sucursal">Sucursal</label>
                     <input id="sucursal" class="form-control" type="text" name="sucursal" placeholder="Nombre de la Institución">
                  </div>  
                  
                  <div class="form-group position-relative">
                     <label for="institucion">Institución</label>
                     <select id="institucion" class="form-control" name="institucion">
                     <option value="" selected disabled>Seleccione una sucursal</option>
                        <?php foreach ($data['instituciones'] as $row) {?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['institucion']; ?></option>
                        <?php } ?>
                     </select>
                     <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
                  </div>
                            
          
                  <div class="form-group">
                     <!-- <p for="vigilante">Vigilantes</p> -->
                     <p class="mbn-0">Vigilantes</p>
                     <select id="vigilante" class="form-control" name="vigilante[] " multiple="multiple">
                        <?php foreach ($data['vigilantes'] as $row) {?>
                           <option value="<?php echo $row['id']; ?>"><?php echo $row['vigilante']; ?></option>
                        <?php } ?>
                     </select>
   
                  </div>
 
                  <div class="form-group">
                     <label for="ciudad">Ciudad</label>
                     <input id="ciudad" class="form-control" type="text" name="ciudad" placeholder="Nombre de la Institución">
                  </div>
                  <div class="form-group">
                     <label for="direccion">Dirección</label>
                     <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Nombre de la Institución">
                  </div>
                  
                  <button id ="btn_form_sucursal" class="btn btn-primary mt-3" type="button" onclick="registrarSucursal(event);">
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
<script src="<?php echo base_url;?>Assets/js/funciones_sucursal.js"></script>

</body>
</html>
