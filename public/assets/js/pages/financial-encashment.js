
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

function new_link() {
	count++;
	var tr1 = document.createElement("tr");
    var tipopago = document.getElementById("cmbtipopago").value;
    var entidad = document.getElementById("cmbentidad").value; ;
    var valor = document.getElementById("txtvalor").value;
    var referencia = document.getElementById("txtreferencia").value;

    var nomentidad = "";


	tr1.id = count;
	tr1.className = "pagos";

	var delLink =
		'<tr id ="' + count  +'" class="pagos">' +
	    '<th scope="row" class="pago-id">' + count + "</th>" +
		"<td>" +
            '<select type="select" class="form-select disabled" name="cmbtipopago" id="cmbtipopago-' + count + '"value= "' +  tipopago + '">' +
                '<option value="EFE">Efectivo</option>'+
                '<option value="CHQ">Cheque</option>'+
                '<option value="TCR">Tarjeta</option>'+
                '<option value="DEP">Depósito</option>'+
                '<option value="TRA">Transferencia</option>'+
                '<option value="CON">Convenio</option>'+
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
		'<td class="pago-removal">' +
            '<ul class="list-inline hstack gap-2 mb-0">'+
                '<li class="list-inline-item" data-bs-toggle="tooltip"'+
                    'data-bs-trigger="hover" data-bs-placement="top" title="Remove">'+
                    '<a class="text-danger d-inline-block remove-item-btn"'+
                        'data-bs-toggle="modal">'+
                        '<i class="ri-delete-bin-5-fill fs-16"></i>'+
                    "</a>"+
                "</li>"+
            "</ul>"+
        "</td>";

	tr1.innerHTML = document.getElementById("newForm").innerHTML + delLink;

	

	document.getElementById("newlink").appendChild(tr1);
    var genericExamples = document.querySelectorAll("[data-trigger]");
	genericExamples.forEach(function (genericExamp) {
		var element = genericExamp;
		new Choices(element, {
			placeholderValue: "This is a placeholder set in the config",
			searchPlaceholderValue: "This is a search placeholder",
		});
	});
	
	remove();
	cobros();
	resetRow();
    resetcontrol()
}

remove();
/* Set rates + misc */
var taxRate = 0.0;
var shippingRate = 0.0;
var discountRate = 0.0;

function remove() {
	document.querySelectorAll(".pago-removal a").forEach(function (el) {
		el.addEventListener("click", function (e) {
			removeItem(e);
			resetRow()
		});
	});
}

function resetRow() {

	document.getElementById("newlink").querySelectorAll("tr").forEach(function (subItem, index) {
		var incid = index + 1;
		subItem.querySelector('.pago-id').innerHTML = incid;

	});
}

/* Remove item from cart */
function removeItem(removeButton) {
	removeButton.target.closest("tr").remove();
	recalculateCart();
}

/* Recalculate pago */
function recalculateCart() {
	var montopago = 0;

	document.getElementsByClassName("pago").forEach(function (item) {
		item.getElementsByClassName("pago-line-valor").forEach(function (e) {
			if (e.value) {
				montopago += parseFloat(e.value.slice(1));
			}
		});
	});

	/* Calculate totals */
	document.getElementById("cart-pago").value =
		paymentSign + montopago.toFixed(2);
	
}

function resetcontrol() {
	document.getElementById("cmbtipopago").value = "EFE";
    document.getElementById("txtentidad").value = "";
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

function chkpago() {
	
	var deudas = document.getElementsByClassName("deudas");
	var count = 1;
	var subtotal = 0; 
	var descuento = 0;
	var total = 0;
	

	deudas.forEach(element => {
		var col_desc  = element.querySelector("#desc-"+count).value;
		var col_saldo = element.querySelector("#saldo-"+count).value;
		var col_select = element.querySelector("#chkpago-"+count).checked;
		
		if (col_select) {
			subtotal += parseFloat(col_saldo);
			descuento += parseFloat(col_desc)*-1;
		}
				
		count++;
	});
	total += subtotal+descuento;
	document.getElementById("cart-subtotal").value = paymentSign + subtotal.toFixed(2);
	document.getElementById("cart-descuento").value = paymentSign + descuento.toFixed(2);
	document.getElementById("cart-total").value = paymentSign + total.toFixed(2);

}


cobros();
function cobros() {
	
	Array.from(document.getElementsByClassName("pagos")).forEach(function (item) {
		Array.from(item.getElementsByClassName("pago-line-valor")).forEach(function (e) {
			if (e.value) {
				valorpago += parseFloat(e.value.slice(1));
			}
		});
	});

	document.getElementById("cart-pago").value = paymentSign + valorpago.toFixed(2);
	document.getElementById("cart-totalfact").value = paymentSign + valorpago.toFixed(2);

}






