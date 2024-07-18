<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Supervisiones</span> 
      </div>
   </div>

   <!-- <div class="d-flex justify-content-center justify-content-md-start">
      <div>
         <label for="salida">Salida</label>
         <input id="salida" class="form-control" type="datetime-local" name="salida" placeholder="Hora de salida">
      </div>

      <div >
         <label for="salida">Salida</label>
         <input id="salida" class="form-control" type="datetime-local" name="salida" placeholder="Hora de salida">
      </div>

      <div class="">
         <button class="btn btn-primary mb-2" type="button" onclick="descargarPdf();">
            Descargar <i class="fas fa-file-pdf"></i>
         </button>
      </div>
   </div> -->



      <div >               
         <!-- <form method="post" id="frmReporte" action="">
            <input type="hidden"id="id" name="id">   
            <div class="row">
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inicio">Inicio</label>
                     <input id="inicio" class="form-control" type="date" name="inicio">
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="fin">Fin</label>
                     <input id="fin" class="form-control" type="date" name="fin">
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <button class="btn btn-primary mb-2" type="button" onclick="enviarRango(event);">
                        Ver fechas 
                     </button>
                  </div>
               </div>

               <div class="col-md-2">
                  <div class="form-group ">
                     <button class="btn btn-primary mb-2" type="button" onclick="descargarPdf();">
                        Descargar <i class="fas fa-file-pdf"></i>
                     </button>
                  </div>
               </div>
            </div>         
         </form> -->






         <form class="row row-cols-lg-auto g-3 align-items-center" method="post" id="frmReporte" action="">
            <div class="col-12"> 
                  <label for="inicio"  class="fw-bold">Fecha inicial</label>
                  <input id="inicio" class="form-control" type="date" name="inicio">
            </div>
            <div class="col-12">
               <label for="fin"  class="fw-bold">Fecha final</label>
               <input id="fin" class="form-control" type="date" name="fin">
            </div>

            <div class="col-12 marTop-4-5 ">
               <button class="btn btn-primary me-3" type="button" onclick="enviarRango(event);">
                  Buscar en rango <i class="fas fa-calendar"></i>
               </button>
               <button class="btn btn-primary" type="button" onclick="descargarPdf();">
                  Descargar <i class="fas fa-file-pdf"></i>
               </button>
            </div>
         </form>










      </div>
         
   <table class="table  table-light table-bordered custom-table" id="tblRepSupervisiones">
       <thead class="thead-dark">
               <tr>
                  <th>Nº</th>  
                  <th>Fecha</th>
                  <th>Sucursal</th>
                  <th>Vigilante</th>
                  <th>Puntualidad</th>
                  <th>Pres. Pers.</th>  
                  <th>Patrulla</th>  
                  <th>Epp</th>
                  <th>Libro</th>  
                  <th>Verif. Vehi.</th>  
                  <th>Ubicacion</th>
               </tr>           
         </thead>
   </table>    
<?php include "Views/Templates/footer.php";?>
<script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: "AIzaSyArnsC-St34MYG-ZWpAlcwl6r0k_mLZMbA",
    v: "weekly",
  });
</script>
<script src="<?php echo base_url;?>Assets/js/funciones_reporte_supervisiones.js"></script>

</body>
</html>
