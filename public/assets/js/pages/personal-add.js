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
    
    document.getElementById("txtpersonaid").value = personaid
    document.getElementById("pernombres").value = pernombres
    document.getElementById("perapellidos").value = perapellidos
    document.getElementById("pertipoident").value = pertipo
    document.getElementById("perident").value = perident
    document.getElementById("pergenero").value = pergenero
    document.getElementById("pernacionalidad").value = pernacion
    document.getElementById("pertelefono").value = pertelefono
    document.getElementById("perrelacion").value = perrelacion
    document.getElementById("peremail").value = peremail
    document.getElementById("perdireccion").value = perdireccion
    document.getElementById("addfamily-btn").style.display = 'none'
    document.getElementById("editfamily-btn").style.display = ''
    

    document.getElementById("pernombres").disabled = false
    document.getElementById("perapellidos").disabled = false
    document.getElementById("pertipoident").disabled = false
    document.getElementById("perident").disabled = false
    document.getElementById("pergenero").disabled = false
    document.getElementById("pernacionalidad").disabled = false
    document.getElementById("pertelefono").disabled = false
    document.getElementById("perrelacion").disabled = false
    document.getElementById("peremail").disabled = false
    document.getElementById("perdireccion").disabled = false
    document.getElementById("addfamily-btn").disabled = false
    document.getElementById("editfamily-btn").disabled = false

}

function familyData() {

    if (document.getElementById("pernombres").value.length > 0){
        pernombres = document.getElementById("pernombres").value
    }

    if (document.getElementById("perapellidos").value.length > 0){
        perapellidos = document.getElementById("perapellidos").value
    }

    if (document.getElementById("perident").value.length > 0){
        perident = document.getElementById("perident").value
    }

    if (document.getElementById("pertelefono").value.length > 0){
        pertelefono = document.getElementById("pertelefono").value
    }

    if (document.getElementById("perdireccion").value.length > 0){
        perdireccion = document.getElementById("perdireccion").value
    }

    //var e = document.getElementById("pertipoident")
    //var pertipo = e.options[e.selectedIndex].value

    //var e = document.getElementById("pergenero")
    //var pergenero = e.options[e.selectedIndex].value

    //var e = document.getElementById("pernacionalidad")
    //var pernacion = e.options[e.selectedIndex].value

    //var e = document.getElementById("perrelacion")
    //var perrelacion = e.options[e.selectedIndex].value
   
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