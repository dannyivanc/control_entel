<?php include "Views/Templates/header.php";?>

   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Registro de entrada - salida de Materiales</span> 
      </div>
      <table class="table">
         <tbody>
            <tr>
               <td class="table-secondary"  style="width: 10%">Institucion</td>
               <td> <?php echo($data['institucion']);?></td>
            </tr>
            <tr>
               <td class="table-secondary">Sucursal</td>
               <td> <?php echo($data['sucursal']);?></td>
            </tr>
         </tbody>
      </table>
   </div>
   
   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmMaterial();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>

   <table class="table  table-light table-bordered  custom-table" id="tblMateriales">
         <thead class="thead-dark">
            <tr>
               <th>Nº</th>  
               <th>Fecha</th>
               <th>Movimiento</th>
               <th>Descripcion</th>
               <th>Personal</th>  
               <th>Origen/Destino</th>  
               <th>Observaciones</th> 
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 
   <div id="nuevo_material" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="title">Nuevo Registro</h5>
               <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
               </button>
            </div>
            <div class="modal-body">
               
               <form method="post" id="frmMaterial" action="">
                  <input type="hidden"id="id" name="id">   
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="fecha">Fecha</label>
                           <input id="fecha" class="form-control" type="datetime-local" name="fecha" placeholder="Hora de registro">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group position-relative">
                           <label for="movimiento">Movimiento</label>
                           <select class="form-control" id="movimiento" name="movimiento">
                              <option value="" selected disabled>Seleccione una opción</option>
                              <option value="ingreso">Ingreso</option>
                              <option value="salida ">Salida</option>
                           </select>
                           <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
                        </div>
                     </div>
                  </div> 
                     
                  <div class="form-group">
                     <label for="persona">Nombre del personal</label>
                     <input id="persona" class="form-control" type="text" name="persona" placeholder="Nombre">
                  </div>
                  <div class="form-group">
                     <label for="destino">Destino/Origen</label>
                     <input id="destino" class="form-control" type="text" name="destino" placeholder="Destino/Origen">
                  </div>
                  <div class="form-group">
                     <label for="descripcion">Descripción</label>
                     <textarea id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Descripción"></textarea>
                  </div>       
                  <div class="form-group">
                     <label for="observacion">Observaciones</label>
                     <input id="observacion" class="form-control" type="text" name="observacion" placeholder="Observaciones">
                  </div>     
                     
                  <button id ="btn_form_material" class="btn btn-primary mt-3" type="button" onclick="registrarMaterial(event);">
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
<script src="<?php echo base_url;?>Assets/js/funciones_material.js"></script>

</body>
</html>
