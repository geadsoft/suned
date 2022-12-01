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

            var pernombres   = document.getElementById("pernombres").value
            var perapellidos = document.getElementById("perapellidos").value
            var pertelefono  = document.getElementById("pertelefono").value
            var perrelacion  = document.getElementById("perrelacion")
            var perdireccion = document.getElementById("perdireccion").value
            var inffullname1 = document.getElementById("txtnombres").value 
            var inffullname2 = document.getElementById("txtapellidos").value
            var infnui       = document.getElementById("txtnui").value
            var infdireccion = document.getElementById("txtdireccion").value

            var textrel = perrelacion.options[perrelacion.selectedIndex].text;

            var cmbgrupo = document.getElementById("cmbgrupoId")
            var cmbnivel = document.getElementById("cmbnivelId")
            var cmbgrado = document.getElementById("cmbgradoId")
            var cmbcurso = document.getElementById("cmbcursoId")

            var textgrupo = cmbgrupo.options[cmbgrupo.selectedIndex].text;
            var textnivel = cmbnivel.options[cmbnivel.selectedIndex].text;
            var textgrado = cmbgrado.options[cmbgrado.selectedIndex].text;
            var textcurso = cmbcurso.options[cmbcurso.selectedIndex].text;

            document.getElementById("infofullname").value = inffullname1 + ' ' + inffullname2
            document.getElementById("infonui").value = infnui
            document.getElementById("infoaddress").value = infdireccion
            
            document.getElementById("infoname").value = pernombres + ' '+ perapellidos
            document.getElementById("inforelacion").value = textrel
            document.getElementById("infotelefono").value = pertelefono
            document.getElementById("infodireccion").value = perdireccion

            document.getElementById("infogrupo").value = textgrupo
            document.getElementById("infonivel").value = textnivel
            document.getElementById("infogrado").value = textgrado
            document.getElementById("infocurso").value = "Curso/Paralelo: "+textcurso
            
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