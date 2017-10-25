$(document).ready(function(){
	if ($(".fecha").length > 0 || $(".hasta").length > 0) {
	
	$.datepicker.regional['es'] = {
	 closeText: 'Cerrar',
	 prevText: '< Ant',
	 nextText: 'Sig >',
	 currentText: 'Hoy',
	 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	 weekHeader: 'Sm',
	 dateFormat: 'dd/mm/yy',
	 firstDay: 1,
	 isRTL: false,
	 showMonthAfterYear: false,
	 yearSuffix: ''
	 };
	 $.datepicker.setDefaults($.datepicker.regional['es']);

		$(".fecha").datepicker({
			dateFormat: 'yy-mm-dd'

			});
		$(".hasta").datepicker({
			dateFormat: 'yy-mm-dd',
			 onSelect: function(date) {
				if($(".fecha").val()==""){
					$( ".fecha" ).focus();

				}else{
					$('form#rango').submit();
				}
	        }
			});
	}
	$('.cliente-cxc').click(function() {
			
			var co_cli = $(this).text();
			
			$.ajax({
			data: {"co_cli" : co_cli },
			type: "POST",
			url: "../controlclientes.php?opcion=cxccliente",
				success: function(data){
					$('#modal-cxc .modal-content').empty();
					$('#modal-cxc .modal-content').append(data);
			  }
		});
		$("#modal-cxc").modal()
	});

	$('.ven-clientes-actuales').click(function() {
		
		var co_ven = $(this).parent().parent().attr('id');	
		var tipo = $(this).parent().attr('id');	

		var hasta = $("#hasta").val();
			
			$.ajax({
			data: {"co_ven" : co_ven,"hasta" : hasta,"tipo" : tipo},
			type: "POST",
			url: "../controlclientes.php?opcion=clientesActuales",
				success: function(data){
					$('#modal-cxc .modal-content').empty();
					$('#modal-cxc .modal-content').append(data);
			  }
		});
		$("#modal-cxc").modal()
	});



	 $('[data-toggle="popover"]').popover();
	 $('[data-toggle="tooltip"]').tooltip();

	$('#permanente').click(function() {
	
		if ($(this).is(':checked')) {
			$("#finicio").prop('disabled', true);
			$("#fsalir").prop('disabled', true);
		}else{
			$('#finicio').removeAttr('disabled','disabled');
			$("#finicio").prop('disabled', false);
			$("#fsalir").prop('disabled', false);
		}
	});

	$('#tipo-comision').change(function() {
		var tipo = $("#tipo-comision option:selected").text();
		if(tipo =="Combo"){
			$("#combo").prop('disabled', false);

		}else{
			$("#combo").prop('disabled', true);


		}
	});

	/*var productos;
		$.ajax({
			data: {"parametro1" : "valor1", "parametro2" : "valor2"},
			type: "POST",
			 dataType: "json",
			url: "cargarproductosJSON.php",
				success: function(data){
					$("#articulos-combo").tagit({
						availableTags: data
					});
			  },
				
		});*/


});
function soloNumero(e){
   key = e.keyCode || e.which;
   tecla = String.fromCharCode(key).toLowerCase();
   letras = "0123456789.";
    especiales = "8-37-39-46";
   tecla_especial = false
   for(var i in especiales){
		if(key == especiales[i]){
			tecla_especial = true;
			break;
		}
	}

	if(letras.indexOf(tecla)==-1 && !tecla_especial){
		return false;
	}
}
