

function cashReportData() {

    var dataperiodo = document.getElementById("cmbperiodo").value
    var datagrupo = document.getElementById("cmbgrupo").value
    var datafecha = document.getElementById("fechaActual").value

    alert(dataperiodo);
    
    var data_obj = {
        periodo: dataperiodo,
        grupo: datagrupo,
        fecha: datafecha,        
    }

    Livewire.emit('dataReport',data_obj); 

}