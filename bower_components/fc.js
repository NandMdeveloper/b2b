$(document).ready(function(){
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

	$('.preciosforma').on('change',function(){
		var val = $('.preciosforma').val();
	});
	$('.preciosforma').number( true, 2 );

  $(".fecha").datepicker({dateFormat: 'yy-mm-dd'});



	$(".hasta").datepicker({
		dateFormat: 'yy-mm-dd',
		 onSelect: function(date) {
       $('#myModal').modal();
            $('form#rango').submit();
        }
		});
	$('[data-toggle="popover"]').popover();
	  $('[data-toggle="tooltip"]').tooltip();

 if( $('.comisiones').length > 0){
	var rating = $('.totalgeneral').text().replace(/^.*: ([\d\.]+).*$/, '$1'); // Extract the rating
      $('.ntotalgeneral').text(rating); 
      
	var rating2 = $('.totalventas').text().replace(/^.*: ([\d\.]+).*$/, '$1'); // Extract the rating
      $('.ntotalventas').text(rating2);  

	var rating3 = $('.totalporcentajetradicional').text().replace(/^.*: ([\d\.]+).*$/, '$1'); // Extract the rating
      $('.ntotalporcentajetradicional').text(rating3); 


      var totalCuentasClaves = $('.totalCuentasClaves').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.ntotalCuentasClaves').text(totalCuentasClaves); 
     
      var totalProhome = $('.totalProhome').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.ntotalProhome').text(totalProhome); 
     
      var totalVentasProhome = $('.totalVentasProhome').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.ntotalVentasProhome').text(totalVentasProhome);    

      var totalPresupuestoClaves = $('.totalPresupuestoClaves').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.ntotalPresupuestoClaves').text(totalPresupuestoClaves); 
            
      var totalPresupuestoProhome = $('.totalPresupuestoProhome').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.ntotalPresupuestoProhome').text(totalPresupuestoProhome);     

      var participaciontradicional = $('.participaciontradicional').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.nparticipaciontradicional').text(participaciontradicional);  
                
      var participacionclave = $('.participacionclave').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.nparticipacionclave').text(participacionclave);

      var alcanceClave = $('.alcanceClave').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.nalcanceClave').text(alcanceClave);   

         var porcantaleTotalProHome = $('.porcantaleTotalProHome').text().replace(/^.*: ([\d\.]+).*$/, '$1');
      $('.nporcantaleTotalProHome').text(porcantaleTotalProHome); 
}

      if( $('.vacante').length > 0){
      	 $('.vacante').change(function(){
	        if($('.vacante').val() == 'VACANTE') {
	           $('#nzonas').show(); 
	           $('#nzonas').removeClass('hidden');	            
	        } else {
	        	$('#nzonas').hide(); 
	        	 $('#nzonas').addClass('hidden');	          
	        } 
    	});
      }  
   $('.nombreGerente').on('change',function(){
      var co_ven = $('.nombreGerente').val();
      var co_desc = $(".nombreGerente option:selected").text();
      var res = co_desc.split(" ");
     
     
      if(res.length==4){
          var nombre = res[0];
          var apellido = res[2];
         $('#nombre').val(nombre);
         $('#apellido').val(apellido);
      }else{
          var nombre = res[0];
          var apellido = res[1];
         $('#nombre').val(nombre);
         $('#apellido').val(apellido);
      }
      
   });
  $(".modal-comision").click(function(){

      event.preventDefault();

      var docs = [];

      $("#dataTables-example input:checkbox:checked").map(function(){
        docs.push($(this).val());
      });
 
      $(".item-comision").remove();
      for (var i = docs.length - 1; i >= 0; i--) {
        $( "#"+docs[i]+"").trigger( "click" );
        if( $("#"+docs[i]+".item-comision").length==0){
        var campos = '<tr id="'+docs[i]+'" class="item-comision"><td>'+docs[i]+'</td>'
                              +'<td>'
                                +'<div class="form-group">'
                                    +'<div class="col-lg-10">'
                                       +'<input  id="'+docs[i]+'" type="hidden" name="doch[]" value="'+docs[i]+'">'
                                       +'<input class="form-control fecha" id="f-'+docs[i]+'" placeholder="Fecha" type="text"  onfocus="montarFecha(this.id)"  name="fecha[]">'
                                    +'</div>'
                                +'</div>'
                              +'</td>'
                                 +'<td>'
                                 +'<div class="form-group"> '   
                                +'<div class="col-lg-10">'
                                  +'<input class="form-control" id="porcentaje" placeholder="Porcentaje" type="text"  name="porcentaje[]">'
                                 +'</div>'
                               +'</div>'
                               +'</td>'
                                +'<td>'
                                 +'<div class="form-group"> '   
                                +'<div class="col-lg-10">'
                                  +'<input class="form-control" id="reserva" placeholder="Porcentaje" type="text"  name="reserva[]">'
                                 +'</div>'
                               +'</div>'
                               +'</td>'
                                +'<td>'
                                 +' <button type="submit" class="btn btn-danger" onclick="eliminarLinea(\''+docs[i]+'\')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                                  +'<input  id="final" type="hidden" name="final[]" value="<>">'
                               +'</td>'
                           + '</tr>';
                $('#docs-modificar tr:first').after(campos);

        }
      
        
      }  
     $("#modal-cambios").modal();
    });      
  

   $( ".excel" ).click(function() {
      var link = $(this).attr("href");   
      $.ajax({
          type:'GET',
          url:link,
          data: {},
          dataType:'json'
      }).done(function(data){
          var $a = $("<a>");
          $a.attr("href",data.file);
          $("body").append($a);
          $a.attr("download","file.xls");
          $a[0].click();
          $a.remove();
      });


    });

        $('.link-borrar').click(function(event) {
    event.preventDefault();
    var r=confirm("Realmente desea eliminar este elemento?");
    if (r==true)   {  
       window.location = $(this).attr('href');
    }

  });
 });
function registrarComisionesUno(desde,hasta) {
    var txt;
    
    var r = confirm("Registrará los pagos de estas facturas en este periodo ¿Desea continuar?");
    if (r == true) {
      $.ajax({
        url: "controlcomisiones.php?opcion=registrarFacturas",
        type: "post",
        data: "desde="+desde+"&hasta="+hasta ,
         dataType:'JSON', 
        beforeSend: function(){
              $('#myModal').modal();
                   },
        success: function (data) {
           // you will get response from your php page (what you echo or print)                 
            $('#myModal').modal('hide');
            alert("registros realizados: "+data.registrados)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });
  }else{
    txt = "Cancelar!";
  }
}
Notification.requestPermission();

function spawnNotification(theBody,theIcon,theTitle,tiempo) {
  var options = {
      body: theBody,
      icon: theIcon
  }
  var n = new Notification(theTitle,options);
  setTimeout(n.close.bind(n), tiempo); 
}
function montarFecha(id) {
   
    $("#"+id+"").datepicker({
      dateFormat: 'yy-mm-dd', maxDate:"+0D"
   
      });
 } 
function prueba_notificacion(titulo,cuerpo,tiempo) {

        if (Notification) {

            if (Notification.permission !== "granted") {

                Notification.requestPermission()

            }
            var title = titulo
            var extra = {

                icon: "http://xitrus.es/imgs/logo_claro.png",
                body: cuerpo

            }
            var noti = new Notification( title, extra)
            noti.onclick = {

              

            }
            noti.onclose = {

             

            }
            setTimeout( function() { noti.close() }, tiempo)

        }

    }

function agregarDocumentosConCambios() {

    event.preventDefault();
      var docs = [];

      $("#docs-modificar input").map(function(){
        docs.push($(this).val());
      });

      $.ajax({
        type: "POST",
        url: "controlcomisiones.php?opcion=arbitrario",
        data:'docs='+docs,
        dataType: 'JSON',
        success: function(data){
          $('#modal-cambios').modal('toggle');
            alert("Se modificaron: "+data["realizados"]+" y encontraron ya documentos en la BD: "+data["encontrados"]);
        }
      });

 } 

 function eliminarLinea(id) {
 
    $("tr#"+id+"").remove();
    return false;

 } 
function prueba_notificacion(titulo,cuerpo,tiempo) {

        if (Notification) {

            if (Notification.permission !== "granted") {

                Notification.requestPermission()

            }
            var title = titulo
            var extra = {

                icon: "../../images/logoPS.png",
                body: cuerpo

            }
            var noti = new Notification( title, extra)
            noti.onclick = {

              

            }
            noti.onclose = {

             

            }
            setTimeout( function() { noti.close() }, tiempo)

        }

    }
function getSubLineas(val) {
    $.ajax({
      type: "POST",
      url: "controlopd.php?opcion=cargarsublinea",
      data:'linea='+val,
      success: function(data){
        $("#sublinea").html(data);
      }
    });
}

function getArticulos(val) {
    $.ajax({
      type: "POST",
      url: "controlopd.php?opcion=cargararticulos",
      data:'sublinea='+val,
      success: function(data){
 
        $("#lista-art").html(data);
      }
    });
}

