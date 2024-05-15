<?php include "Views/Templates/header.php";?>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Registro de ingreso y salida de Vehiculos</li>
   </ol>    
   <button class="btn btn-primary mb-2" type="button" onclick="frmVehiculo();">Nuevo   <i class="fas fa-plus"></i></button>  

   <table class="table  table-light custom-table " id="tblVehiculos">
         <thead class="thead-dark">
            <tr>
               <th>Fecha</th>
               <th>Ingreso</th>
               <th>Salida</th>
               <th>Tipo</th>  
               <th>Placa</th>  
               <th>Km</th>    
               <th>Conductor</th>  
               <th>Destino</th>      
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 
   <div id="nuevo_vehiculo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="title">Nuevo Vehiculo</h5>
               <button class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>


            <div class="modal-body">
               <form method="post" id="frmVehiculo" action="">
                  <input type="hidden"id="id" name="id">   
                  <!-- <div class="form-group">
                     <label for="fecha">Fecha</label>                               
                     <input id="fecha" class="form-control" type="datetime-local" name="fecha" placeholder="Fecha de registro">
                  </div> -->
                  <div class="form-group">
                     <label for="ingreso">Ingreso</label>
                     <input id="ingreso" class="form-control" type="datetime-local" name="ingreso" placeholder="Hora de ingreso">
                  </div>
                  <div class="form-group">
                     <label for="salida">Salida</label>
                     <input id="salida" class="form-control" type="datetime-local" name="salida" placeholder="Hora de salida">
                  </div>
                  <div class="form-group">
                     <label for="tipo">Tipo</label>
                     <input id="tipo" class="form-control" type="text" name="tipo" placeholder="Tipo de Vehiculo">
                  </div>
                  <div class="form-group">
                     <label for="placa">Placa</label>
                     <input id="placa" class="form-control" type="text" name="placa" placeholder="Placa de Vehiculo">
                  </div>
                  <div class="form-group">
                     <label for="kilometraje">Kilometraje</label>
                     <input id="kilometraje" class="form-control" type="text" name="kilometraje" placeholder="Kilometraje de Vehiculo">
                  </div>
                  <div class="form-group">
                     <label for="conductor">Conductor</label>
                     <input id="conductor" class="form-control" type="text" name="conductor" placeholder="Conductor de Vehiculo">
                  </div>
                  <div class="form-group">
                     <label for="destino">Destino/Origen</label>
                     <input id="destino" class="form-control" type="text" name="destino" placeholder="Destino- Origen de Vehiculo">
                  </div>
               
               
                  <div class="form-group">
                     <!-- <label for="institucion">Institucion</label> -->
                  
                  
                     <button id ="btn_form_usuario" class="btn btn-primary mt-3" type="button" onclick="registrarUser(event);">
                           Registrar
                        </button>
                        <button class="btn btn-danger  mt-3" type="button" data-dismiss="modal">
                           Cancelar
                     </button>
                  </div>


               </form>
            </div>
         
         </div>
      </div>
   </div>
<?php include "Views/Templates/footer.php";?>