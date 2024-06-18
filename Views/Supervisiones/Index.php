<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Supervisión de Proyecto</span> 
      </div>
      <!-- <table class="table">
         <tbody>
           <tr>
               <td class="table-secondary"  style="width: 10%">Institucion</td>
               <td> <?php echo($data['institucion']['institucion']);?></td>
            </tr>
         </tbody> 
      </table> -->
   </div>
   
   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmMaterial();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>

   <table class="table  table-light table-bordered  custom-table" id="tblSupervisiones">
         <thead class="thead-dark">
            <tr>
               <th>Nº</th>  
               <th>Fecha</th>
               <th>Vigilante</th>
               <th>Puntualidad</th>
               <th>Pres. Pers.</th>  
               <th>Patrulla</th>  
               <th>Epp</th>
               <th>Libro</th>  
               <th>Verif. Vehi.</th>  
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 
   <div id="nuevo_supervision" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
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
                        <div class="form-group position-relative">
                        <label for="id_institucion">Institución</label>
                        <select id="id_institucion" class="form-control" name="id_institucion">
                        <option value="" selected disabled>Seleccione una opción</option>
                           <?php foreach ($data['instituciones'] as $row) {?>
                                 <option value="<?php echo $row['id']; ?>"><?php echo $row['institucion']; ?></option>
                           <?php } ?>
                        </select>
                        <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
                        </div>
                     </div>

                     <div class="col-md-6">
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
                     </div>
                  </div> 

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group position-relative">
                           <label for="id_vigilante">Vigilantes</label>                        
                           <select id="id_vigilante" class="form-control" name="id_vigilante">
                           <option value="" selected disabled>Seleccione una opción</option>
                              <?php foreach ($data['vigilantes'] as $row) {?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['vigilante']; ?></option>
                              <?php } ?>
                           </select>
                           <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <button class="btn btn-primary mt-4" type="button" onclick="obtenerUbicacion();">
                           Obtener ubicación
                        </button>
                     </div>
                  </div> 

                  
                  
                  <div id="map" class="mt-3"></div>

                  <div class="row" >
                     <div class="col-md-4">
                        <label >Puntualidad</label>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="presentacion" id="PresentacionSi" checked>
                           <label class="form-check-label" for="PresentacionSi">
                              Si
                           </label>
                           </div>
                           <div class="form-check">
                           <input class="form-check-input" type="radio" name="presentacion" id="PresentacionNo">
                           <label class="form-check-label" for="PresentacionNo">
                              No
                           </label>
                        </div>
                     </div>
                     <div class="col-md-4">
                     <label >Presentacion</label>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="Patrulla" id="Patrulla1" checked>
                           <label class="form-check-label" for="Patrulla1">
                              Si
                           </label>
                           </div>
                           <div class="form-check">
                           <input class="form-check-input" type="radio" name="Patrulla" id="Patrulla2" >
                           <label class="form-check-label" for="Patrulla2">
                              No
                           </label>
                        </div>
                     </div>
                     
                     <div class="col-md-4">
                     <label >Patrulla</label>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="epp" id="epp1" checked>
                           <label class="form-check-label" for="epp1">
                              Si
                           </label>
                           </div>
                           <div class="form-check">
                           <input class="form-check-input" type="radio" name="epp" id="epp2" >
                           <label class="form-check-label" for="epp2">
                              No
                           </label>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                     <div class="col-md-4">
                        <label >Epp</label>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="presentacions" id="PresentacionSis" checked>
                           <label class="form-check-label" for="PresentacionSis">
                              Si
                           </label>
                           </div>
                           <div class="form-check">
                           <input class="form-check-input" type="radio" name="presentacions" id="PresentacionNso">
                           <label class="form-check-label" for="PresentacionNso">
                              No
                           </label>
                        </div>
                     </div>
                     <div class="col-md-4">
                     <label >Libro</label>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="libro" id="libro1" checked>
                           <label class="form-check-label" for="libro1">
                              Si
                           </label>
                           </div>
                           <div class="form-check">
                           <input class="form-check-input" type="radio" name="libro" id="libro2" >
                           <label class="form-check-label" for="libro2">
                              No
                           </label>
                        </div>
                     </div>
                     
                     <div class="col-md-4">
                     <label >Verif. vehi.</label>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cscsc" id="cscsc1" checked>
                           <label class="form-check-label" for="cscsc1">
                              Si
                           </label>
                           </div>
                           <div class="form-check">
                           <input class="form-check-input" type="radio" name="cscsc" id="cscsc2" >
                           <label class="form-check-label" for="cscsc2">
                              No
                           </label>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="form-group">
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
                  </div>      -->
                     
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArnsC-St34MYG-ZWpAlcwl6r0k_mLZMbA"></script>
<script src="<?php echo base_url;?>Assets/js/funciones_supervisiones.js"></script>

</body>
</html>
