
var paymentSign = "$";
document.getElementsByClassName("pago-line-valor").forEach(function (item) {
	item.value = paymentSign +"0.00"
});

function chkbill() {
	if (document.getElementById("chkbill").checked) {
		document.getElementById("pills-bill-info-tab").click()
	} else {
		document.getElementById("pills-bill-address-tab").click() 
	}
}

var count = 0;
var deuda_list = localStorage.getItem("deuda-list");
var totalpago = 0;

function new_link() {
	count++;
	var tr1 = document.createElement("tr");
	tr1.id = count;
	tr1.className = "pagos";

    var tipopago = document.getElementById("cmbtipopago").value;
    var entidad = document.getElementById("cmbentidad").value;
    var valor = document.getElementById("txtvalor").value;
    var referencia = document.getElementById("txtreferencia").value;
	totalpago +=  parseFloat(valor);

    var nomentidad = "";

	var selectEFE = "";
	var selectCHQ = "";
	var selectTAR = "";
	var selectDEP = "";
	var selectTRA = "";
	var selectCON = "";
	var selectOTR = "";
	var selectAPP = "";
	var selectRET = "";

	switch(tipopago) {
		case "EFE":
			selectEFE = "selected"
		  break;
		case "CHQ":
			selectCHQ = "selected"
		  break;
		case "TAR":
			selectTAR = "selected"
			entidad   = document.getElementById("cmbtarjeta").value;
		  break;
		case "DEP":
			selectDEP = "selected"
		  break;
		case "TRA":
			selectTRA = "selected"
		  break;
		case "CON":
			selectCON = "selected"
		  break;
		case "OTR":
			selectOTR = "selected"
		  break;
		case "APP":
			selectAPP = "selected"
		  break;
		case "RET":
			selectRET = "selected"
		  break;
	  }
	
	var delLink =
		'<tr>' +
	    '<th scope="row" class="pagos-id">' + count + "</th>" +
		"<td>" +
            '<select type="select" class="form-select disabled" name="cmbtipopago" id="cmbtipopago-' + count + '"value= "' +  tipopago + '">' +
                '<option value="EFE"'+ selectEFE +'>Efectivo</option>'+
                '<option value="CHQ"'+ selectCHQ +'>Cheque</option>'+
                '<option value="TAR"'+ selectTAR +'>Tarjeta</option>'+
                '<option value="DEP"'+ selectDEP +'>Depósito</option>'+
                '<option value="TRA"'+ selectTRA +'>Transferencia</option>'+
                '<option value="CON"'+ selectCON +'>Convenio</option>'+
				'<option value="APP"'+ selectAPP +'>App Movil</option>'+
                '<option value="RET"'+ selectRET +'>Retención</option>'+
				'<option value="OTR"'+ selectOTR +'>Convenio</option>'+
            "</select>"+
		"</td>" +
        "<td>" +
            '<input type="text" class="form-control" id="txtreferencia-' + count + '" value= "' + nomentidad + "-" + referencia + '" readonly/>' +
		"</td>" +
		'<td style="display:none;">' +
            '<input type="text" class="form-control pago-entidad" id="cmbentidad-' + count + '" value= "' + entidad + '" readonly/>' +
		"</td>" +
		"<td>" +
	    	'<input type="number" class="form-control pago-line-valor"  id="txtvalor-' + count + '" step="0.01" value= "' + valor + '" readonly/>' +
		"</td>" +
		'<td class="pagos-removal">' +
            '<ul class="list-inline hstack gap-2 mb-0">'+
                '<li class="list-inline-item" data-bs-toggle="tooltip"'+
                    'data-bs-trigger="hover" data-bs-placement="top" title="Remove">'+
                    '<a href="" class="text-danger d-inline-block remove-item-btn"'+
                        'data-bs-toggle="modal">'+
                        '<i class="ri-delete-bin-5-fill fs-16"></i>'+
                    "</a>"+
                "</li>"+
            "</ul>"+
        "</td>";
		"</tr>";

	document.getElementById("cart-pago").value = paymentSign + totalpago.toFixed(2);
	document.getElementById("cart-totalfact").value = paymentSign + totalpago.toFixed(2);
	
	tr1.innerHTML = document.getElementById("newForm").innerHTML + delLink;
	document.getElementById("newlink").appendChild(tr1);
	/*var genericExamples = document.querySelectorAll("[data-trigger]");
	genericExamples.forEach(function (genericExamp) {
		var element = genericExamp;
		new Choices(element, {
			placeholderValue: "This is a placeholder set in the config",
			searchPlaceholderValue: "This is a search placeholder",
		});
	});*/

	
	remove();
	resetRow();
    resetcontrol();
}


remove();
/* Set rates + misc */
var taxRate = 0.0;
var shippingRate = 0.0;
var discountRate = 0.0;
var valorpago = 0.0;

function remove() {
	
	valorpago = document.getElementById("txtvalor").value;

	/*document.querySelectorAll(".pago-removal ul li a").forEach(function (el) {*/
	Array.from(document.querySelectorAll(".pagos-removal ul li a")).forEach(function (el) {
		el.addEventListener("click", function (e) {
			removeItem(e);
			resetRow()
		});
	});
}

function resetRow() {

	document.getElementById("newlink").querySelectorAll("tr").forEach(function (subItem, index) {
		var incid = index + 1;
		subItem.querySelector('.pagos-id').innerHTML = incid;

	});
}

/* Remove item from cart */
function removeItem(removeButton) {
	removeButton.target.closest("tr").remove();
	recalculateCart();
}

/* Recalculate pago */
function recalculateCart() {
	totalpago = totalpago-valorpago;

	document.getElementsByClassName("pago").forEach(function (item) {
		item.getElementsByClassName("pago-line-valor").forEach(function (e) {
			if (e.value) {
				totalpago += parseFloat(e.value.slice(1));
			}
		});
	});

	/* Calculate totals */
	document.getElementById("cart-pago").value = paymentSign + totalpago.toFixed(2);
	document.getElementById("cart-totalfact").value = paymentSign + totalpago.toFixed(2);
	
}

function resetcontrol() {

	document.getElementById("cmbtipopago").value = "EFE";
    document.getElementById("cmbentidad").value = "32";
    document.getElementById("txtvalor").value = 0.00;
    document.getElementById("txtreferencia").value = "";
	
 }

var genericExamples = document.querySelectorAll("[data-trigger]");
genericExamples.forEach(function (genericExamp) {
	var element = genericExamp;
	new Choices(element, {
		placeholderValue: "This is a placeholder set in the config",
		searchPlaceholderValue: "This is a search placeholder",
	});
});

var lineadeuda = 0;
function chkpago(fila) {
	
	var deudas = document.getElementsByClassName("deudas");
	localStorage.removeItem("deuda-list");

	lineadeuda = 1;
	var subtotal = 0; 
	var descuento = 0;
	var total = 0;
	var new_deudas_obj = [];

	var saldo  = document.getElementById("saldo-"+fila).value;
	var desct  = document.getElementById("desc-"+fila).value;
	var chksel = document.getElementById("chkpago-"+fila).checked;

	if (chksel){
		var neto   = parseFloat(saldo)-parseFloat(desct);
		document.getElementById("neto-"+fila).value = neto.toFixed(2);
	}else{
		document.getElementById("desc-"+fila).value = parseFloat(total);
		document.getElementById("neto-"+fila).value = parseFloat(saldo).toFixed(2);
	}
	
	deudas.forEach(element => {
	
		var deuda_desct  = element.querySelector("#desc-"+lineadeuda).value;
		var deuda_saldo = element.querySelector("#saldo-"+lineadeuda).value;
		var deuda_select = element.querySelector("#chkpago-"+lineadeuda).checked;
		var valor_pago = parseFloat(deuda_saldo)-parseFloat(deuda_desct);
		
		var deuda_id = element.querySelector("#id-"+lineadeuda).value;
		var deuda_detalle = element.querySelector("#detalle-"+lineadeuda).value;

		if (deuda_select) {
			subtotal += parseFloat(deuda_saldo);
			descuento += parseFloat(deuda_desct)*-1;
			
			var deuda_obj = {
				id: deuda_id,
				desct: deuda_desct,
				detalle: deuda_detalle,
				saldo: deuda_saldo,
				valpago: valor_pago,
			}
			new_deudas_obj.push(deuda_obj);

		} 

		lineadeuda++;
	});

	total += subtotal+descuento;
	
	document.getElementById("cart-subtotal").value = paymentSign + subtotal.toFixed(2);
	document.getElementById("cart-descuento").value = paymentSign + descuento.toFixed(2);
	document.getElementById("cart-total").value = paymentSign + total.toFixed(2);
	localStorage.setItem("deuda-list",JSON.stringify(new_deudas_obj));

}


document.addEventListener("DOMContentLoaded", function () {
	// //Form Validation
	var formEvent = document.getElementById('encashment_form');

	formEvent.addEventListener("submit", function (event) {
		event.preventDefault();

		var deudas = document.getElementsByClassName("deudas");
		var count = 1;
		var new_deuda_obj = [];

		Array.from(deudas).forEach(element => {

			var deuda_id = element.querySelector("#id-"+count).value;
			var deuda_desct = element.querySelector("#desc-"+count).value;
			var deuda_saldo = element.querySelector("#saldo-"+count).value;
			var deuda_detalle = element.querySelector("#detalle-"+count).value;
			var deuda_select = element.querySelector("#chkpago-"+count).checked;
			
			
			var deuda_obj = {
				id: deuda_id,
				desct: deuda_desct,
				saldo: deuda_saldo,
				detalle: deuda_detalle,
				select: deuda_select,
			}
			new_deuda_obj.push(deuda_obj);
			count++;
		});

		console.log(new_deuda_obj);
	});


});	


var modal = $('#searchModal');

$('#btnAdd').click(function(){
	modal.show();
});

    








