
function viewInstitucion(id,institucion) { 

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