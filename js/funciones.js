// JavaScript Document



var x;



//x=$(document);



//////////////////////////////////////////////////////////////////////////////////ancho////////////

//////////////////////////////////FUNCIONES GENERICAS/////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////





function clear_caja(id)

{

	$("#"+id).val('');

}





//////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////FUNCIONES GENERICAS/////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////



function prueba(parametro)

{		

	alert(parametro.length);

}



function prueba_asinc(id_carga,id_llamada)

{		

	/*	

		id_carga	id donde se va a cargar la pagina

		url			pagina de carga

		id_llamada	id_donde se hace la llamada	

	*/

	var dato=$("#"+id_llamada).val();

	if(dato==1){	$("#"+id_carga).html('<img src="../images/ajax-loader.gif" />');	}

	if(dato==2){	$("#"+id_carga).html(dato);		}

	if(dato==3){	$("#"+id_carga).load('usuario_add.php');	}

	

}

//CARGA DE SELEC DEPENDIENTES

function LoadSelectDepended(id_carga,id_llamada,url)

{		

	/*	

		id_carga	id donde se va a cargar la pagina

		url			pagina de carga

		id_llamada	id_donde se hace la llamada	

	*/

	var dato=$("#"+id_llamada).val();

	

	$("#"+id_carga).html('<img src="../images/ajax-loader.gif" />');	

	$("#"+id_carga).load(url+'?id='+dato);	

	

}





function load_page_client(id_carga,url,id_llamada,id,dir)

{		

	/*	

		id_carga	id donde se va a cargar la pagina

		url			pagina de carga

		id_llamada	id_donde se hace la llamada	

	*/

	var latlon=$("#"+id_llamada).val();

	var dir=$("#"+dir).val();

	//alert('qui llegamos'+latlon);

	vlatlon=latlon.split(',');

	latitud=vlatlon[0];	

	longitud=vlatlon[1];			

	$("#"+id_carga).load(url+'?latlon='+latlon+'&latitud='+latitud+'&longitud='+longitud+'&co_cli='+id+'&id_carga='+id_carga+'&dir='+dir);

}



//CARGA DE ASINCRONIA DE LAS LATITUDES TALLERES

function load_page_taller(id_carga,url,id_llamada,id,dir)

{		

	/*	

		id_carga	id donde se va a cargar la pagina

		url			pagina de carga

		id_llamada	id_donde se hace la llamada	

	*/

	var latlon=$("#"+id_llamada).val();

	var dir=$("#"+dir).val();

	//alert('qui llegamos'+latlon);

	vlatlon=latlon.split(',');

	latitud=vlatlon[0];	

	longitud=vlatlon[1];			

	$("#"+id_carga).load(url+'?latlon='+latlon+'&latitud='+latitud+'&longitud='+longitud+'&codigo='+id+'&id_carga='+id_carga+'&dir='+dir);

}





function cargaNewClient(campo,url,idCarga){

	if($("#"+campo).val()=='1'){

	//	alert(url);

		$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" >');

		$("#"+idCarga).load(url);

	}else{

		$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" >');

		$("#"+idCarga).html('');

	}

}



function cargarMetas(mes,ano,idCarga,tipo,url,pase){
	var mes=$("#"+mes).val();	
	var ano=$("#"+ano).val();
	var tipo=$("#"+tipo).val();
	if(mes!=0 && ano!=0){	
		//espacio de car para un gif animado
		$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" >');
		$("#"+idCarga).load(url+'?mes='+mes+'&ano='+ano+'&idCarga='+idCarga+'&pase='+pase+'&tipo='+tipo);
	}else{
		$("#"+idCarga).html('Perdone debe seleccionar el Mes y el A&ntilde;o');
	}
}

//INCLUYE LA CATEGORIA
function cargarMetas1(mes,ano,idCarga,tipo,url,pase,categoria){
	var mes=$("#"+mes).val();	
	var ano=$("#"+ano).val();
	var tipo=$("#"+tipo).val();
    var categoria=$("#"+categoria).val();
	if(mes!=0 && ano!=0){	
		//espacio de car para un gif animado
		$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" >');
		$("#"+idCarga).load(url+'?mes='+mes+'&ano='+ano+'&idCarga='+idCarga+'&pase='+pase+'&tipo='+tipo+'&categoria='+categoria);
	}else{
		$("#"+idCarga).html('Perdone debe seleccionar el Mes y el A&ntilde;o');
	}
}

//RENE BRICENO 06022012, CARGAR METAS POR COODINACION MOD 29062012 se agrego categoria para el flitro
function cargarMetasC2(mes,ano,idCarga,tipo,url,pase,coordinacion,categoria){
	var mes=$("#"+mes).val();	
	var ano=$("#"+ano).val();
	var tipo=$("#"+tipo).val();
    var coordinacion=$("#"+coordinacion).val();
    var categoria=$("#"+categoria).val();
    
	if(mes!=0 && ano!=0){	
     // alert(url+'?mes='+mes+'&ano='+ano+'&idCarga='+idCarga+'&pase='+pase+'&tipo='+tipo+'&coordinacion='+coordinacion+'&categoria='+categoria);
		//espacio de car para un gif animado
		$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" >');
		$("#"+idCarga).load(url+'?mes='+mes+'&ano='+ano+'&idCarga='+idCarga+'&pase='+pase+'&tipo='+tipo+'&coordinacion='+coordinacion+'&categoria='+categoria);
	
	}else{
		$("#"+idCarga).html('Perdone debe seleccionar el Mes y el A&ntilde;o');
	}
}



function cargarMetasMovil(mes,ano,idCarga,tipo,vendedor,url,pase){

	var mes=$("#"+mes).val();	

	var ano=$("#"+ano).val();

	var tipo=$("#"+tipo).val();

	var vendedor=$("#"+vendedor).val();



	if(mes!=0 && ano!=0 && vendedor!=0){	

		//espacio de car para un gif animado

		$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" >');

		$("#"+idCarga).load(url+'?mes='+mes+'&ano='+ano+'&idCarga='+idCarga+'&pase='+pase+'&tipo='+tipo+'&vendedorD='+vendedor);

	

	}else{

		$("#"+idCarga).html('Perdone debe seleccionar el Mes y el A&ntilde;o y Vendedor o Coordinador');

	}

	

	

}





function carga_data_vehiculo(id_vehiculo){

	id=$("#"+id_vehiculo).val();	

	

	if(id!=0){

		

		$("#vehiculo_mensaje").load('asin_data_vehiculo.php?id='+id);

	

	}

	

	

}





function load_page(id_carga,url,id_llamada)

{	

	/*	id_carga	id donde se va a cargar la pagina

		url			pagina de carga

		id_llamada	id_donde se hace la llamada	*/

		

	$("#"+id_carga).load(url+'?id_llamada='+id_llamada);



}



function load_pool(id_carga,url,id_tabla,id_edit)

{	

		/*

			id_carga		DONDE SE VA A CARGAR EL NUEVO POOLDAWN

			url				pagina asincrona

			id_tabla		id de donde se mana a llamr es decir de donde se etsa opteniendo el valor por el cual se discriminara el siguiente pool

		*/





			var id_tabla=$("#"+id_tabla).val();

			//alert(id_tabla);

			$("#"+id_carga).html('');

			$("#"+id_carga).load(url+'?id_tabla='+id_tabla+'&id_edit='+id_edit);

}





function load_multiple(id_carga,url,id_tabla){

	var id_tabla=$("#"+id_tabla).val();

	id_carga=id_carga.split(',');

	url=url.split(',');

	cuantos=id_carga.length;

	for(i=0;i<cuantos;i++){

			$("#"+id_carga[i]).html('');

			$("#"+id_carga[i]).load(url[i]+'?id_tabla='+id_tabla);

		

	}

	

}



function update_meta(id_carga,id_caja,id,url){

	var id_caja=$("#"+id_caja).val();

	$("#"+id_carga).load(url+'?id='+id+'&id_caja='+id_caja);

}



function update_campo(id_carga,id_caja,id,url){

	var id_caja=$("#"+id_caja).val();

	$("#"+id_carga).load(url+'?id='+id+'&id_caja='+id_caja);

}





function oculta_filas(id_fila,num_filas){

	//id_fila es la fila q se va a ocultar este debe tener un fortamo ejemplo fila_ o fina al cual se le agregara el indice

	//	del for para buscar el verdadero id

	//num_filas numero de filas a ocultar

	

	for(i=0;i<num_filas;i++){

		$("#"+id_fila+i).addClass('not_display');

	}

	

}



function mostrar_fila(id_fila,num_filas,posicion,id_llamada){

	/*	PARAMETROS DE LA FUNCION

		id_fila es la fila q se va a ocultar este debe tener un fortamo ejemplo fila_ o fina al cual se le agregara el indice

			del for para buscar el verdadero id

		num_filas numero de filas a ocultar

		posicion fila q se va a mostrar

		id_llamada este es el campo donde se va a colocar la ruta, es de acotar hay un campo oculto con el nombre h_+d_llamada es donde se guarda el valor de la 

			posicion de la escaa en la base datos, con esto se evita hacer el ordenamiento en el mismo servidor lo cual garantiza mas rapides

		

	*/

	oculta_filas(id_fila,num_filas);

	$("#"+id_fila+posicion).removeClass('not_display');

	$("#"+id_llamada).val('');

	$("#h_"+id_llamada).val('');

	$("#id_"+id_llamada).val('');

	limpia_calcula_tabulador('valor_viaje','valor_escolta','valor_adelanto','valor_caleta','carga_monto');

	

	

}



function avilitaCheque(parametros,url){

	/*DETALLES DE LA FUNCION

		esta funcion se encarga de llamar a la ascincrona  para que inserte un pequeno formulario adicional de el cheque		

		

		parametros

		parametros[0] -> tabla_cheques  / donde se adjuntara las nuevas facturas 

		parametros[1] -> cch			/ contador de los indices de facturas

		parametros[2] -> respuestach	/ donde se coloca la respuesta de la factura recioen insertada

		parametros[3] -> tdCheque		/ td donde se inserta el cheque

			

		url								/ esta es una variable que tiene el url del asincrono php

	*/

	pr=parametros.split(',');

		

	cch=$("#"+pr[1]).val();//contador de cheques

	tablaCarga=pr[0];//nombre de la tabla que va aser padre

	tdCarga=pr[3];//nombre del ted donde a la larga se iinsertara el nuevo seccion de cheues de cheques

	

	cch++;

	$("#"+pr[1]).val(cch);//actualizamos el vvalor de la caja

	

	//luego de tener el valor de la caja contadora de cheques pasamos a insertar  la fila q la contendra

	//creacion y emparentamiento de elemntos del DOM

	tdCarga=tdCarga+cch;

	$("#"+tablaCarga).append('<tr ><td id="'+tdCarga+'">uno"'+cch+'"</td></tr>');



	//AQUI PASAMOS A LLAMAR A EL ASINCRONO

	

	$("#"+tdCarga).load(url+'?cch='+cch);

	

}





function avilitaFactura(parametros,url){

	/*DETALLES DE LA FUNCION

		esta funcion se encarga de llamar a la ascincrona  para que consulte los datos e inserte una nueva fila en la tabla identidicada por idCarga

		usa una variable parametros para q no se corten en el pase de la funcion

		

		parametros

		parametros[0] -> tabla_facturas / donde se adjuntara las nuevas facturas 

		parametros[1] -> sucursal		/ donde se saca la sucursal para la factura

		parametros[2] -> factura		/ donde optenemos las facturas

		parametros[3] -> cf				/ contador de los indices de facturas

		parametros[4] -> respuestas		/ donde se coloca la respuesta de la factura recioen insertada

		

	*/

	pr=parametros.split(',');

	

	var sucursal=$("#"+pr[1]).val(); // sucursal

	

	factura=$("#"+pr[2]).val();//factura

	cf=$("#"+pr[3]).val();//contador de filas

	

	pp=pr[0]+','+sucursal+','+factura+','+cf+','+pr[4]+','+pr[3];

	

	

	cf=$("#"+pr[3]).val();//contador de filas

	sw=0; //swiche de existencia

	for(i=0;i<cf;i++){

		//si encontramos una sla coinsidencia la registramos  no ejecutamos el asincrono

		if($("#facAso"+i).val()==sucursal+factura)	sw=1;

	}

	

	if(!sw) { //si no existe

		$("#"+pr[4]).load(url+'?parametros='+pp);	

	}

	

}









function addFila(parametros){

	/*PARAMETROS DE LA FUNCION

		parametros 	contiene una serie de parametros traidos desde la primera llamada en el onchange de fac_num_

					se describen a continuacion

		parametros[0] -> /factura que recivimos

		parametros[1] -> /datos del cliente

		parametros[2] -> /monto de la factura

		parametros[3] -> /contador de filas

		parametros[4] -> /id de la carga

		parametros[5] -> /identificador de la factura verdadero

		parametros[6] -> /contador nombre del contador

	*/

	//	

	

	

	pr=parametros.split(',');

	cf=pr[3];

		

	// CONSRUCCION DEL HTML DE ESTE QUE ADICIONARA LA FATURA

	tablaCarga=pr[4];//tabla donde se cargan la  factura

	trCarga='trC'+cf;//tr en el q se carga la nueva linea de factura

	tdCarga='tdC'+cf;//tr en el q se carga la nueva linea de factura

	//deckaracion de los nombres de los campos

	campoFacAso='facAso'+cf;//campo de la factura asociada a a el campo que se esta llenando

	campoMonApa='monApa'+cf;//campo a pagar de la factura

	

	//creacion y emparentamiento de elemntos del DOM

	$("#"+tablaCarga).append('<tr id="'+trCarga+'"></tr>');

	$("#"+trCarga).append('<td id="'+tdCarga+'"></td>');

	

	//elementos de formularios

	camposOcultos='<input type="hidden" id="'+campoFacAso+'" name="'+campoFacAso+'" value="'+pr[5]+'"  />';

	camposMontoApa='<input type="text" id="'+campoMonApa+'" name="'+campoMonApa+'" value=""  class="form_text_cheque" maxlength="12"    />';

	

	tData='<table width="100%" class="tablas_filtros">';

	tData+='<tr><td height="10" align="left" class="form_label" width="77" >Factura</td><td height="10" align="left"   >'+pr[0]+'</td></tr>';

	tData+='<tr><td height="10" align="left" class="form_label" width="77"  >Cliente</td><td height="10" align="left"   >'+pr[1]+'</td></tr>';

	tData+='<tr><td height="10" align="left" class="form_label" width="77"  >Monto</td><td height="10" align="left"   >'+pr[2]+'</td></tr>';

	tData+='<tr><td height="10" align="left" class="form_label" width="77" >A Pagar</td><td height="10" align="left"   >';

	tData+=camposOcultos+camposMontoApa+'</td></tr>';

	tData+='<tr><td align="left"  height="30" colspan="2"  ><img src="../images/img_line_separadora.png" width="100%" height="1px"/></td></tr>';

	tData+='</table>';

	

	//

	$("#"+tdCarga).html(tData);	    //cargo la parte interna 

	//actualizamos a cf

	cf++;

	$("#"+pr[6]).val(cf);//contador de filas aumenta en uno el indice

	

	

}





//funcetion oara determinar el ancho de la pantalla

function ancho(error){

//	alert('hola');

	//determino el ancho de la pantalla

	var ancho = screen.availWidth;

	

	if(ancho<=500)

		window.location.replace("modulos/index.php?error="+error);

	else

		window.location.replace("modulos/index.php?error="+error);

	

}





function popup_basic(url) {

	

var opciones= "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=800, height=600, top=10, left=200";

window.open(url,"",opciones);

}





//FUNCIONES DE ASINCRONIA AJAX CON JQUERY



function udpAjaxBasic(inputString,inputId,stringEdit,idLoad,url) {

	/*	SECCION DE EXPLICACION DE VARIABLES

		inputString				valor del campo que queremos editar

		inputId					id del formulario de este campo 

		stringEdit				strin que se debera desconcatenar donde para hacerlo de manera sencilla se pasan: en sese mismo orden y separado por ,,, tres comas

									compoTable	nombre de el campo de la tabla

									table		nombre de la tabla

									IdTable		identificador de la tabla columna unica

									valIdTable		valor del id de la tabla

		idLoad					id donde se cargara el asincrono

		url						direccion del archivo asincrono que se encargara de la edicion

	*/

	//alert(inputString+'  '+inputId+'  '+stringEdit+'  '+idLoad+'  '+url);

		if(inputString){

			$.post(url, {inputString: ""+inputString+"", stringEdit: ""+stringEdit+""}, function(data){

					$("#"+inputId).addClass('form_caja_metas_alert');

					$("#"+idLoad).html(data);

					

			});

		}

} // udpAjaxBasic

	



	

//FUNCIONES DE ASINCRONIA AJAX CON JQUERY



//funcion paginadora

function paginadora(mov,cambios,total){

	/*

		funcion que se encarga de cambiar el indice de las guias

		mov			direccion de la paginacion a anterior s siguiente

		cambios		caja que contiene la posicion actual

		totao		de guias

	*/

	//alert('hace paginadora');

	var total=$("#"+total).val();

	var camb=$("#"+cambios).val();

	if(mov=='a') ncamb=parseInt(camb)-1;

	if(mov=='s') ncamb=parseInt(camb)+1;	

	if(ncamb>=0 && ncamb<total)	$("#"+cambios).val(ncamb);

	if(total>0){

		

		//busca las quias a mostrar hasta ahorita

		load_page('cargaDataAsin','asinAccData.php');

	

	}

}



function changePos(pos,contData,idCarga,total){

	//pos posicion actual

	//contData char de imahenes a mostrar

	//idCarga  id donde se va a cargar

	var t=$("#"+total).val();

	var p=$("#"+pos).val();

	 p=parseInt(p)+1;

	// alert('hola'+p+'  '+total);

	if(p>=t) $("#"+pos).val(0); else $("#"+pos).val(p);

	busPos(pos,contData,idCarga);

}



function busPos(pos,contData,idCarga){

	//pos posicion actual

	//contData char de imahenes a mostrar

	//idCarga  id donde se va a cargar

	var p=$("#"+pos).val();

	var data=$("#"+contData).val();

	var imagen=data.split('@@@');

	pinImg(imagen[p],idCarga);

}



function pinImg(dato,idCarga){

	//contData	donde esta la data que debemos usar

	//idCarga	donde vamos a cargar la imagen

	$("#"+idCarga).html('<img src="../images/ajax-loader_amarllo.gif" />');

	$("#"+idCarga).html('<img src="'+dato+'" />');

}



///////////////////////////////////INICIO  FUNCIONES MERVIN////////////////////////////////////////////
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
	return this.replace(/^\s+/g,"");
}
String.prototype.rtrim = function() {
	return this.replace(/\s+$/g,"");
}


 var numero=1; //variable global para colocarla en las filas de productos creadas para identificar cada campo por fila
	function validarProductoCargado(num) {
            
            if (document.getElementById('cliente').value==0 || document.getElementById('cliente').value==''){
                alert('Debe seleccionar un clientes antes de seleccionar el producto');
                return;
            }
                
            
		variable_1=1;
		divi="b"+num.toString();
		numero1=num.toString();
		var i=1;
		var limit=numero;
		var comprobar,variable,actual,bandera;
		bandera=0;
		elemento="productos_list"+numero1;
		actual=document.getElementById(elemento).value;
		if (limit>1){
		while(i<limit && bandera==0){
			variable="productos_list"+i;
			if (variable!=elemento && document.getElementById(variable)!=null){
			
			comprobar=document.getElementById(variable).value;
			if (comprobar==actual){
			bandera=1;
			}
			}
			++i;
		}
		}
		if (bandera==0){
                        document.getElementById("cantidad"+num).value="";
                        document.getElementById("calculo"+num).innerHTML="";
                        document.getElementById("precio"+num).value="";
                        document.getElementById("des"+num).value="";
                        divi=num;
                        cargando="cargando_prod";
                        document.getElementById("capa_superior1").className="sombra12";
                        document.getElementById("capa_superior1").style.display="block";
                        document.getElementById("cargando_prod").style.display="block";
                        general1('dat1='+actual+'&dat2='+document.getElementById('cliente').value+'&opc=1','../lib/class/ClaseGeneral.php');
		}else{
			alert("El Codigo "+actual+" ya Fue Seleccionado");
		//	document.form12.elemento.reset();
		//document.getElementById(divi).innerHTML="";
		document.getElementById(elemento).selectedIndex=0;
		
		
		}
	}
        
        function enviarProductos(opcion,opc){
            var numeros=/^[0-9]{0,}$/ ;
            if (document.getElementById('cliente').value==0 || document.getElementById('cliente').value==''){
                alert('Debe seleccionar un clientes antes de seleccionar el producto');
                return;
            } 
            var i=0;
            var bloq_ped="";
            var correos="";
            var codigos="";
            var cantidades="";
            var descuentos="";
            var precio="";
            var pedido_sap="";
            var bandera=0;
            for (i=1;i<numero;i++){
                if (document.getElementById('productos_list'+i)!=null){
if (document.getElementById('productos_list'+i).selectedIndex!=0 && document.getElementById('cantidad'+i).value!='' && document.getElementById('precio'+i).value!=''){
    codigos+=document.getElementById('productos_list'+i).value+'|';
    cantidades+=document.getElementById('cantidad'+i).value+'|';
    descuentos+=document.getElementById('des'+i).value+'|';
    precio+=document.getElementById('precio'+i).value+'|';
    bandera=1;
}
                }
            }
              if (document.getElementById('tip_pedido').selectedIndex==0){
                    alert('Debe seleccionar el tipo de pedido');
                        return;
                }            
                
              if (document.getElementById('retencion').value==0 || document.getElementById('retencion').value==''){
                alert('Debe seleccionar si el cliente es agente de retención o no');
                return;
            }
            if (document.getElementById('retira').value==0 || document.getElementById('retira').value==''){
                alert('Debe seleccionar si el cliente retirara la mercancia o no');
                return;
            }
            
            if (document.getElementById('bloq_ped_sel') && opcion==2){
                bloq_ped=document.getElementById('bloq_ped_sel').value;
                if (document.getElementById('bloq_ped_sel').selectedIndex==0){
                    resp=confirm('Seguro que desea enviar el pedido sin ningun bloqueo');
                    if (resp==false)
                        return;
                }
                
                correos=document.getElementById('correos').value;
                if (!numeros.test(document.getElementById('pedido_sap').value)){
                    alert('Solo puede ingresar numeros en el campo pedido cliente SAP');
                    return;
                }
                pedido_sap=document.getElementById('pedido_sap').value;
            }
      if (bandera==1){
          var combo=document.getElementById('cliente');
  parametros='dat1='+document.getElementById('cliente').value+'|'+combo.options[combo.selectedIndex].text+'&dat2='+codigos+'&dat3='+encodeURIComponent(cantidades)+'&dat4='+encodeURIComponent(descuentos)+'&dat5='+precio+'&dat6='+encodeURIComponent(document.getElementById('observaciones').value)+'&dat7='+opcion+'&dat8='+bloq_ped+'&dat9='+correos+'&dat10='+pedido_sap+'&dat11='+document.getElementById('co_sucu').value+'&dat12='+document.getElementById('destina_cliente').value+'&dat13='+document.getElementById('tip_pedido').value+'&dat14='+document.getElementById('retencion').value+'&dat15='+document.getElementById('retira').value+'&opc='+opc;
 // alert(parametros);
  divi="calculo_produc";
  cargando="cargando_prod";
                        document.getElementById("capa_superior1").className="sombra12";
                        document.getElementById("capa_superior1").style.display="block";
                        document.getElementById("cargando_prod").style.display="block";
                        //document.getElementById('cliente').selectedIndex=0;
    general1(parametros,'../lib/class/ClaseGeneral.php');
      }
        }
        
       function validarcliente(variable){
           if (numero!=1){
          resp=confirm('Al cambiar al cliente se eliminaran las filas de los productos. Esta seguro de cambiar el cliente');
          if (resp==true){
              document.getElementById('prueba').innerHTML="";
          }
           }
           divi="destino_cliente";
           document.getElementById(divi).innerHTML="";
           general1("dat1="+document.getElementById("cliente").value+"&opc=3",'../lib/class/ClaseGeneral.php');
       }
       
       function limpiar(){
           document.getElementById('prueba').innerHTML="";
       }

function cargar_precio(num_id){
    var inser2=document.getElementById("capa_superior");
    inser2.className="capa_s";
    document.getElementById("capa_superior1").className="sombra12";
    inser2.style.display="block";
    document.getElementById("capa_superior1").style.display="block";
    var id_prod=document.getElementById('productos_list'+num_id).value;
    
    general1('dat1='+id_prod+'&opc=1','../lib/class/modelo.php');
}

function cerrar_capa(capa){
    document.getElementById(capa).style.display="none";
    cerrar();
}

//FUNCIONAGREGADA EL 22-03-2012 PARA QUITAR EL BOTON DE FINALIZAR DEL FORMULARIO Y NO PUEDAN ENVIAR 2 VECES EL FORMULARIO EVITANDO EL ENIVO DE LA INFORMACION  2 VECES Q PUEDE CREAR DUPLICIDAD EN LA BASE DE DATOS
function enviarDatosPedido(){

var bloqueo=document.getElementById('bloq_ped_sel').value;
    var resp='';
    if (bloqueo==""){
        resp=confirm('Seguro que desea enviar pedido sin ningun bloqueo');
    
  if (resp==false)
      return;
  else{
       document.getElementById('op0').style.visibility='hidden';
       document.getElementById('op1').style.visibility='hidden';
       document.getElementById('cargando').innerHTML='<img src="../images/cargando.gif" title="Cargando" alt="Cargando /><br>...CARGANDO..."';
       document.form1.submit();
    }
    }else{
       document.getElementById('op0').style.visibility='hidden';
       document.getElementById('op1').style.visibility='hidden';
       document.getElementById('cargando').innerHTML='<img src="../images/cargando.gif" title="Cargando" alt="Cargando /><br>...CARGANDO..."';
       document.form1.submit();      
    }

  
}
function men(){
    alert('eliminar');
    return;
}
function subcalculo(num){
    var numeros=/^[0-9]{1,}$/;
    var resta;
    var a=parseFloat(document.getElementById('subtotal'+num).value);
    var b=parseFloat(document.getElementById('total').value);
    var precio=parseFloat(document.getElementById('precio'+num).value);
    
        var can=parseInt(document.getElementById('cantidad'+num).value);
        
        if (!numeros.test(can)){
            alert('debe ingresar solo numeros en las cantidades');
            return;
        }else{
            
            precio=parseFloat(can*precio);
            
            resta=(b-a);
            document.getElementById('subtotal'+num).value=precio.toFixed(2);
            
            var total=parseFloat(resta+precio);
            document.car.total.value=total.toFixed(2);
            var iva=0.12;
            iva=parseFloat(total*iva);
            document.car.iva.value=iva.toFixed(2);
            document.car.totalN.value=(total+iva).toFixed(2);
        }
        
    }
    
    function numberFormat(numero){
        // Variable que contendra el resultado final
        var resultado = "";
 
        // Si el numero empieza por el valor "-" (numero negativo)
        if(numero[0]=="-")
        {
            // Cogemos el numero eliminando los posibles puntos que tenga, y sin
            // el signo negativo
            nuevoNumero=numero.replace(/\./g,'').substring(1);
        }else{
            // Cogemos el numero eliminando los posibles puntos que tenga
            nuevoNumero=numero.replace(/\./g,'');
        }
 
        // Si tiene decimales, se los quitamos al numero
        if(numero.indexOf(",")>=0)
            nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf(","));
 
        // Ponemos un punto cada 3 caracteres
        for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
            resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + resultado;
 
        // Si tiene decimales, se lo añadimos al numero una vez forateado con 
        // los separadores de miles
        if(numero.indexOf(",")>=0)
            resultado+=numero.substring(numero.indexOf(","));
 
        if(numero[0]=="-")
        {
            // Devolvemos el valor añadiendo al inicio el signo negativo
            return "-"+resultado;
        }else{
            return resultado;
        }
    }
    function formatoNumero(numero, decimales, separadorDecimal, separadorMiles) {
    var partes, array;

    if ( !isFinite(numero) || isNaN(numero = parseFloat(numero)) ) {
        return "";
    }
    if (typeof separadorDecimal==="undefined") {
        separadorDecimal = ",";
    }
    if (typeof separadorMiles==="undefined") {
        separadorMiles = ".";
    }

    // Redondeamos
    if ( !isNaN(parseInt(decimales)) ) {
        if (decimales >= 0) {
            numero = numero.toFixed(decimales);
        } else {
            numero = (
                Math.round(numero / Math.pow(10, Math.abs(decimales))) * Math.pow(10, Math.abs(decimales))
            ).toFixed();
        }
    } else {
        numero = numero.toString();
    }

    // Damos formato
    partes = numero.split(".", 2);
    array = partes[0].split("");
    for (var i=array.length-3; i>0 && array[i-1]!=="-"; i-=3) {
        array.splice(i, 0, separadorMiles);
    }
    numero = array.join("");

    if (partes.length>1) {
        numero += separadorDecimal + partes[1];
    }

    return numero;
}


          function enviar_formulario(){
        		document.form_grafica.submit();
                }
                
                function cancelar(capa){
                    document.getElementById(capa).innerHTML="";
                }

function estadistica(ejecutar,datos,grafica){
	divi="capa_superior";
    cargando="cargando";
    var $datos=datos.split('|');
    document.getElementById('datos_graf').value=datos;
    document.getElementById('opc_grafica').value=grafica;
     if (document.getElementById('mes')){
           document.getElementById('mes_reporte').value=document.getElementById('mes').value;
     }
    document.getElementById('anio_reporte').value=document.getElementById('ano').value;
    if (document.getElementById('articulos_lista')){
           document.getElementById('articulo_reporte').value=document.getElementById('articulos_lista').value;

    }
    if (document.getElementById('categoria_lista')){
           document.getElementById('categoria_reporte').value=document.getElementById('categoria_lista').value;

    }
    if (document.getElementById('tipo')){
           document.getElementById('tipo_reporte').value=document.getElementById('tipo').value;

    }

    if (document.getElementById("capa_superior")){
    var inser2=document.getElementById("capa_superior");
    inser2.className="capa_s";
    document.getElementById("capa_superior1").className="sombra12";
    inser2.style.display="block";
    document.getElementById("capa_superior1").style.display="block";
    }
document.form_grafica.submit();
  //      $html+='<div style="float:left;margin-right:1px solid #404040;width:30%;">                  <form method="post" target="i_grafica" action="graficas.php" enctype="multipart/form-data" name="form_grafica">                <table width="100%" height="100%" border="0">                <tbody>                <tr>                 <td valign="top"><div id="menu_graficas">                    <table border="1" style="border-collapse:collapse;">                      <tbody>                      <tr><th>                      Graficas                      <input type="hidden" value="'+$datos[0]+'" id="meta" name="meta">                        <input type="hidden" value="'+$datos[1]+'" id="pedido" name="pedido">                        <input type="hidden" value="'+$datos[2]+'" id="cumplido" name="cumplido">                        <input type="hidden" value="'+$datos[3]+'" id="puntos" name="puntos">                        <input type="hidden" value="'+grafica+'" id="opc_grafica" name="opc_grafica">                      </th>                      </tr>                      <tr><td><a href="javascript:enviar_formulario();"><span style="color:red">Porcentaje de Solicitudes por Estado</span></a></td></tr>                      <tr><td><a href="javascript:llamado(3,\'381|2\');"><span style="color:red">Solicitudes por Año</span></a></td></tr>                      <tr><td><a href="javascript:llamado(3,\'381|3\');"><span style="color:red">Promedio de Tiempo</span></a></td></tr>                    <tr><td><a href="javascript:cerrarCapa();"><span style="color:red">Cerrar</span></a></td></tr>            </tbody>            </table>        </div>        </td>        </tr>        </table>                    </form>                            </div>                            <div style="width:70%;">                        <iframe width="99%" height="99%" frameborder="0" name="i_grafica">                            Si Observa Este Mensaje Su Navegador No Soporta iframe                            </iframe>                            </div>                              ';


  // general1('opc=1&dat1='+ejecutar+"&dat2="+encodeURIComponent(datos)+"&dat3="+grafica,'../lib/class/claseGeneral.php');
}
    function cerrar(){
        	var divv2=document.getElementById("capa_superior");
        	var divv3=document.getElementById("capa_superior1");
        	divv3.removeAttribute('class');
        	divv2.removeAttribute('class');
            divv2.style.display="none";
//        	divv2.innerHTML="";
        }

//////////////////////////////////FIN FUNCIONES MERVIN///////////////////////////////////////////////


//////////////////////////////////FUNCIONES EDGAR///////////////////////////////////////////////
function preciosMaestro(){
    divi="capa_tabla";
    parametros='dat1='+document.getElementById('linea').value+'&dat2='+document.getElementById('cliente').value+'&opc=4';
	var inser = document.getElementById(divi);
	inser.innerHTML='<tr><td align="center" colspan="3"><h1>Cargando</h1><br><img src="../images/ajax-loader.gif"></td></tr>';
    general1(parametros,'../lib/class/ClaseGeneral.php');
}

//////////////////////////////////FIN FUNCIONES EDGAR///////////////////////////////////////////////
function calculo(cantidad,precio,inputtext,totaltext){
 
	// Calculo del subtotal
	subtotal = precio*cantidad;
	inputtext.value=subtotal.toFixed(2);
 
        //Calculo del total
	total = eval(totaltext.value);
        total = (total + subtotal).toFixed(2);
	totaltext.value = total;
        var iva=0.12;
        iva=parseFloat(total*iva);
        document.car.iva.value=iva.toFixed(2);
        var totalN=(total+iva).toFixed(2);
        document.car.totalN.value=totalN;
}
function calculoRest(id){

	//Calculo del total
        subtotal = document.getElementById('subtotal'+id).value;
	total = document.getElementById('total').value;
        total=(total - subtotal).toFixed(2);
	document.getElementById('total').value = total;
        iva=parseFloat(0.12);
        iva=parseFloat(total*iva);
        document.car.iva.value=iva.toFixed(2);
        totalN=(total+iva).toFixed(2);
        document.car.totalN.value=totalN;
        
}

$('.delPedido').on('click',function(){
	var id = $(this).data('id');
        eliminar=confirm("¿Desea eliminar este producto?");
        if (eliminar)
            window.location.href = "delproduct.php?codigo="+id;
        //calculoRest(id);
	//$("#pd"+id).remove();
        
})

function delProduct(codigop){
        eliminar=confirm("¿Desea eliminar este producto?");
        if (eliminar)
            window.location.href = "delproduct.php";
}