function viewInstitucion(id,vista) { 
    if(vista=="Patrullaje"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Patrullajes";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="Supervision"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Supervisiones";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }     
    else if(vista=="ReporteSupervision"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteSupervisiones";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="ReportePatrullajes"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReportePatrullajes";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="ReporteVehiculos"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=ReporteVehiculos";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="ReporteMateriales"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=ReporteMateriales";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="ReporteVisitas"){
      console.log('holis')
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=ReporteVisitas";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

    // de aqui
    else if(vista=="RegistroVehiculo"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=RegistroVehiculo";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="RegistroMaterial"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=RegistroMaterial";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="RegistroVisita"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=RegistroVisita";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
  
}