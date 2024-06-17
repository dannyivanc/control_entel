<?php include "Views/Templates/header.php";?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArnsC-St34MYG-ZWpAlcwl6r0k_mLZMbA"></script>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Supervisión de Proyecto</span> 
      </div>
      <table class="table">
         <tbody>
           <tr>
               <td class="table-secondary"  style="width: 10%">Institucion</td>
               <td> <?php echo($data['institucion']);?></td>
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
                     <!-- <div class="col-md-6">
                        <div class="form-group">
                           <label for="fecha">Fecha</label>
                           <input id="fecha" class="form-control" type="datetime-local" name="fecha" placeholder="Hora de registro">
                        </div>
                     </div> -->
                     <div class="col-md-6">
                        <div class="form-group position-relative">
                           <label for="movimiento">Institucion</label>
                           <select class="form-control" id="movimiento" name="movimiento">
                              <option value="" selected disabled>Seleccione una opción</option>
                              <option value="ingreso">Entel</option>
                              <option value="salida ">Union</option>
                              <option value="salida ">Bisa</option>
                           </select>
                           <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group position-relative">
                           <label for="movimiento">Sucursal</label>
                           <select class="form-control" id="movimiento" name="movimiento">
                              <option value="" selected disabled>Seleccione una opción</option>
                              <option value="ingreso">Av. union</option>
                              <option value="salida ">Uyuni (Mercado central)</option>
                              <option value="salida ">Central potosi av. Litoral central centrals </option>
                           </select>
                           <i class="fas fa-chevron-down position-absolute mycustom-arrow" ></i>
                        </div>
                     </div>
                  </div> 
                  <button  class="btn btn-primary mt-3" type="button" onclick="registrarMaterial(event);">
                     Obtener 
                  </button>
                  <div id="map" style="height: 250px; width: 100%;"></div>
                  <div class="row">
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
<script src="<?php echo base_url;?>Assets/js/funciones_material.js"></script>


<script>
        function initMap() {
            // Define las coordenadas del punto
            const latLng = { lat:  -19.583309, lng: -65.759771 }; // Coordenadas de ejemplo (Nueva York)
            // Inicializa el mapa centrado en las coordenadas especificadas
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: latLng
            });

            // Añade un marcador en las coordenadas especificadas
            const marker = new google.maps.Marker({
                position: latLng,
                map: map
            });
        }
        // Llama a la función initMap una vez que la página haya cargado
        window.onload = initMap;
    </script>

</body>
</html>
