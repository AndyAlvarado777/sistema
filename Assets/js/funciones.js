

function frmLogin(e){
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const clave = document.getElementById("clave");

    if(usuario.value == ""){
        clave.classList.remove("is-invalid");
        usuario.classList.add("is-invalid");
        usuario.focus();
    } 
    else if(clave.value == ""){
        usuario.classList.remove("is-invalid");
        clave.classList.add("is-invalid");
        clave.focus();
    } else {
        const frm = document.getElementById("frmLogin");
        const http = new XMLHttpRequest();
        http.open("POST", base_url + "controladores/usuarios_controller.php");
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const params = `usuario=${usuario.value}&clave=${clave.value}`;
        http.send(params);
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){ 
                console.log(this.responseText);
                const response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    alert('Login successful');
                    // Redirigir o hacer algo más en caso de éxito
                } else {
                    alert('Invalid credentials');
                }
            }
        }
    }


}




