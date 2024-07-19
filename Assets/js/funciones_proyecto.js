function viewInstitucion(id,vista) { 
    if(vista=="patrullaje"){
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
    else if(vista=="supervision"){
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
    else if(vista=="reporteSupervision"){
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

  
}