
<div id="nuevo_patrullaje" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
<div class="modal-dialog" role="document">
   <div class="modal-content">
      <div class="modal-header bg-primary">
         <h5 class="modal-title text-white" id="title">Nuevo Registro</h5>
         <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
         </button>
      </div>
      <div class="modal-body">
         
         <form method="post" id="frmPatrullaje" action="">
            <input type="hidden"id="id" name="id" value=""> 
            <input type="hidden"id="lat" name="lat" value=""> 
            <input type="hidden"id="lng" name="lng"> 
 
            <div class="form-group position-relative">
               <label for="id_sucursal">Sucursal</label>
               <select id="id_sucursal" class="form-control" name="id_sucursal">
               <option value="" selected disabled>Seleccione una opción</option>
                  <?php foreach ($data['sucursales'] as $row) {?>
                     <option value="<?php echo $row['id']; ?>"><?php echo $row['sucursal']; ?></option>
                  <?php } ?>
               </select>
               <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
            </div>
            <div class="form-group">
               <label for="destino">Descripción</label>
               <textarea id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Descripción"></textarea>
            </div>  
          
            <div id="btn_obtener" class="row">
               <div class="col-md-6">
                  <button class="btn btn-primary mt-2" type="button" onclick="obtenerUbicacion();">
                     Obtener ubicación
                  </button>
               </div>
            </div> 

            <div id="map" class="mt-3"></div>             
            <button id ="btn_form_patrullaje" class="btn btn-primary mt-3" type="button" onclick="registrarPatrullaje(event);">
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

