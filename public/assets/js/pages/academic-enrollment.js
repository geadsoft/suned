function selecTab(SelectTab) {
    
    switch (SelectTab) {
        case 'pills-bill-students':    
	        document.getElementById('pills-bill-student-tab').click()
            break
        case 'pills-bill-responsible':
            document.getElementById('pills-bill-responsible-tab').click()
            break
        case 'pills-bill-registration':
            
           
            
            document.getElementById('pills-bill-registration-tab').click()
            break
        case 'pills-bill-finish':
            document.getElementById('pills-bill-finish-tab').click()
            break
    }

}

function validarfor(){

    var correo = document.getElementById("peremail").value; 

    var nom = document.getElementById("pernombres").value;
    var ape = document.getElementById("perapellidos").value;
    var tip = document.getElementById("pertipoident").value;
    var ide = document.getElementById("perident").value;
    var gen = document.getElementById("pergenero").value;
    var nac = document.getElementById("pernacionalidad").value;
    var tel = document.getElementById("pertelefono").value;
    var rel = document.getElementById("perrelacion").value;
    var dir = document.getElementById("perdireccion").value;
  
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        
    if ( !expr.test(correo) ){
        alert("Error: La dirección de correo " + correo + " es incorrecta.");
        return false;
    }
    
    if ((correo == "") || (nom == "") || (ape == "") || (tip == "") || (ide == "") || (gen == "") || (nac == "") || (tel == "") || (cel == "") || (coment == "")) {  //COMPRUEBA CAMPOS VACIOS
        alert("Los campos no pueden quedar vacios");
        return true;
    }
    
}