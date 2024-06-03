<?php include "Views/Templates/header.php";?>

   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Registro de entrada - salida de Vehiculos</span> 
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
      <button class="btn btn-primary mb-2" type="button" onclick="frmVehiculo();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>

   <table class="table  table-light custom-table " id="tblVehiculos">
         <thead class="thead-dark">
            <tr>
               <!-- <th>Fecha</th> -->    
               <th>Salida</th>
               <th>Retorno</th>
               <th>Tipo</th>  
               <th>Placa</th>  
               <th>Km Salida</th>
               <th>Km Retorno</th>      
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
               <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
               </button>
            </div>
            <div class="modal-body">
               <form method="post" id="frmVehiculo" action="">
                  <input type="hidden"id="id" name="id">   

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="salida">Salida</label>
                           <input id="salida" class="form-control" type="datetime-local" name="salida" placeholder="Hora de salida">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="retorno">Retorno</label>
                           <input id="retorno" class="form-control" type="datetime-local" name="retorno" placeholder="Hora de retorno">
                        </div>
                     </div>
                  </div>    
                  
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="tipo">Tipo</label>
                           <input id="tipo" class="form-control" type="text" name="tipo" placeholder="Tipo de Vehiculo">
                        </div>
                     </div>
                     <div class="col-md-6">                            
                        <div class="form-group">
                           <label for="placa">Placa</label>
                           <input id="placa" class="form-control" type="text" name="placa" placeholder="Placa de Vehiculo">
                        </div>
                     </div>
                  </div>  

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="km_salida">Kilometraje de Salida</label>
                           <input id="km_salida" class="form-control" type="text" name="km_salida" placeholder="Kilometraje de Retorno">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="km_retorno">Kilometraje de Retorno</label>
                           <input id="km_retorno" class="form-control" type="text" name="km_retorno" placeholder="Kilometraje de Retorno">
                        </div>
                     </div>
                  </div>  
                  <div class="form-group">
                     <label for="conductor">Conductor</label>
                     <input id="conductor" class="form-control" type="text" name="conductor" placeholder="Conductor de Vehiculo">
                  </div>
                  
                  
                  <div class="form-group">
                     <label for="destino">Destino/Origen</label>
                     <textarea id="destino" class="form-control" type="text" name="destino" placeholder="Destino- Origen de Vehiculo"></textarea>
                  </div>
               
                  <button id ="btn_form_usuario" class="btn btn-primary mt-3" type="button" onclick="registrarVehiculo(event);">
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
<script src="<?php echo base_url;?>Assets/js/funciones_vehiculo.js"></script>

</body>
</html>
