<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Patrullajes</span> 
      </div>
      <table class="table">
         <tbody>
            <tr>
               <td class="table-secondary"  style="width: 10%">Institucion</td>
               <td> <?php echo $data['institucion']['institucion']; ?></p></td>
            </tr>

         </tbody>
      </table>
   </div>   
   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmPatrullaje();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>   
   <table class="table  table-light table-bordered  custom-table" id="tblPatrullajes">
         <thead class="thead-dark">
            <tr>
               <th>Nº</th>  
               <th>Fecha</th>
               <th>Sucursal</th>
               <th>Supervisor</th>
               <th>Descripción</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 

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


<?php include "Views/Templates/footer.php";?>

<script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: "AIzaSyArnsC-St34MYG-ZWpAlcwl6r0k_mLZMbA",
    v: "weekly",
  });
</script>
<script src="<?php echo base_url;?>Assets/js/funciones_patrullaje.js"></script>

</body>
</html>
