 function frmLogin(e) {
            e.preventDefault();        
            const usuario = document.getElementById("usuario");
            const clave = document.getElementById("clave");        
            if (usuario.value.trim() === "" || clave.value.trim() === "") {
                document.getElementById("alerta").classList.remove("d-none");
                document.getElementById("alerta").innerHTML = "Por favor, complete todos los campos.";
                return;
            }
        
            const url = base_url + "Usuarios/validar";
            const formData = new FormData(document.getElementById("frmLogin"));
        
            fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error en la solicitud");
                }
            })
            .then(data => {
                if (data === "ok") {
                    window.location = base_url + "Inicio";
                } else {
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = data;
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
