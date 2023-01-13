
var perid = 0;
var personaid = 0;
var pernombres = "";
var perapellidos = "";
var pertipo = "";
var perident = "";
var pergenero = "";
var pernacion = 0;
var pertelefono = "";
var perrelacion = "";
var peremail = "";
var perdireccion = "";

function backTab(SelectTab) {
    switch (SelectTab) {
        case 'pills-bill-students':    
	        document.getElementById('pills-bill-student-tab').click()
            break
        case 'pills-bill-responsible':
            document.getElementById('pills-bill-responsible-tab').click()
            break
        case 'pills-bill-family':
            document.getElementById('pills-bill-family-tab').click()
            break
        case 'pills-bill-registration':
            document.getElementById('pills-bill-registration-tab').click()
            break
        case 'pills-bill-finish':
            document.getElementById('pills-bill-finish-tab').click()
            break
    }
}

function selecTab(SelectTab) {
    
    switch (SelectTab) {
        case 'pills-bill-students':    
	        document.getElementById('pills-bill-student-tab').click()
            break
        case 'pills-bill-responsible':

            var nombres   = document.getElementById("txtnombres").value
            var apellidos = document.getElementById("txtapellidos").value
            var fechanace = document.getElementById("txtfechanace").value
            var identific = document.getElementById("txtnui").value

            if (!this.validate_fecha(fechanace)){
                swal("Error!", "Fecha de nacimiemto incorrecta", "warning");
                return true;
            }

            if ((nombres == "") || (apellidos == "") || (identific == "")) {  //COMPRUEBA CAMPOS VACIOS
                swal("Error!", "Datos del estudiante no deben estar vacios..", "warning");
                return true;
            }

            document.getElementById('pills-bill-responsible-tab').click()
            break
        case 'pills-bill-family':

            var pernombres   = document.getElementById("pernombres").value
            var perapellidos = document.getElementById("perapellidos").value
            var perdirecion  = document.getElementById("perdireccion").value

            if ((pernombres == "") || (perapellidos == "") || (perdirecion == "")) {  //COMPRUEBA CAMPOS VACIOS
                swal("Error!", "Datos del representante no deben estar vacios..", "warning");
                return true;
            }

            document.getElementById('pills-bill-family-tab').click()
            break
        case 'pills-bill-registration':
            
            
           
            document.getElementById('pills-bill-registration-tab').click()
            break
        case 'pills-bill-finish':
            
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

            if ((cmbgrupo.value == "") || (cmbnivel.value == "") || (cmbgrado.value == "") || (cmbcurso.value == "")) {  //COMPRUEBA CAMPOS VACIOS
                swal("Error!", "Datos del registro de matrícula no deben estar vacios..", "warning");
                return true;
            }
            
            document.getElementById('pills-bill-finish-tab').click()
            break
    }

}

function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}

function isValidDate(day,month,year)
{
    var dteDate;
 
    // En javascript, el mes empieza en la posicion 0 y termina en la 11 
    //   siendo 0 el mes de enero
    // Por esta razon, tenemos que restar 1 al mes
    month=month-1;
    // Establecemos un objeto Data con los valore recibidos
    // Los parametros son: año, mes, dia, hora, minuto y segundos
    // getDate(); devuelve el dia como un entero entre 1 y 31
    // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
    //   martes, miercoles ...
    // getHours(); Devuelve la hora
    // getMinutes(); Devuelve los minutos
    // getMonth(); devuelve el mes como un numero de 0 a 11
    // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
    //   de enero de 1970 hasta el momento definido en el objeto date
    // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
    // getYear(); devuelve el año
    // getFullYear(); devuelve el año
    dteDate=new Date(year,month,day);
 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
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

function editFamiliar(id,idpersona,nombres,apellidos,tipo,ident,genero,nacion,telefono,relacion,email,direccion){

    perid = id
    personaid = idpersona
    pernombres = nombres
    perapellidos = apellidos
    pertipo = tipo 
    perident = ident
    pergenero = genero
    pernacion = nacion
    pertelefono = telefono
    perrelacion = relacion
    peremail = email
    perdireccion = direccion
    
    document.getElementById("familiarid").value = personaid
    document.getElementById("nomfamiliar").value = pernombres
    document.getElementById("apefamiliar").value = perapellidos
    document.getElementById("tipfamiliar").value = pertipo
    document.getElementById("idefamiliar").value = perident
    document.getElementById("genfamiliar").value = pergenero
    document.getElementById("nacfamiliar").value = pernacion
    document.getElementById("telfamiliar").value = pertelefono
    document.getElementById("relfamiliar").value = perrelacion
    document.getElementById("emafamiliar").value = peremail
    document.getElementById("dirfamiliar").value = perdireccion
    document.getElementById("addfamily-btn").style.display = 'none'
    document.getElementById("editfamily-btn").style.display = ''
    

    document.getElementById("nomfamiliar").disabled = false
    document.getElementById("apefamiliar").disabled = false
    document.getElementById("tipfamiliar").disabled = false
    document.getElementById("idefamiliar").disabled = false
    document.getElementById("genfamiliar").disabled = false
    document.getElementById("nacfamiliar").disabled = false
    document.getElementById("telfamiliar").disabled = false
    document.getElementById("relfamiliar").disabled = false
    document.getElementById("emafamiliar").disabled = false
    document.getElementById("dirfamiliar").disabled = false
    document.getElementById("addfamily-btn").disabled = false
    document.getElementById("editfamily-btn").disabled = false

}

function familyData() {

    if (document.getElementById("nomfamiliar").value.length > 0){
        pernombres = document.getElementById("nomfamiliar").value
    }

    if (document.getElementById("apefamiliar").value.length > 0){
        perapellidos = document.getElementById("apefamiliar").value
    }

    if (document.getElementById("idefamiliar").value.length > 0){
        perident = document.getElementById("idefamiliar").value
    }

    if (document.getElementById("telfamiliar").value.length > 0){
        pertelefono = document.getElementById("telfamiliar").value
    }

    if (document.getElementById("emafamiliar").value.length > 0){
        pertelefono = document.getElementById("emafamiliar").value
    }

    if (document.getElementById("dirfamiliar").value.length > 0){
        perdireccion = document.getElementById("dirfamiliar").value
    }
   
    var e = document.getElementById("perrelacion")
    var relacion = e.options[e.selectedIndex].value
    if (perrelacion="NN" && relacion!=perrelacion){
        perrelacion = relacion
    }

    var data_obj = {
        id: perid,
        persona_id: personaid,
        apellidos: perapellidos,
        nombres: pernombres,
        tipoidentificacion: pertipo,
        identificacion: perident,
        nacionalidad_id: pernacion,
        genero: pergenero,
        telefono: pertelefono,
        direccion: perdireccion,
        email: peremail,
        parentesco: perrelacion,        
    }

    Livewire.emit('updateFamiliar',data_obj); 

}