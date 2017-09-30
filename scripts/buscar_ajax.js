function AJAX() {
	this.Updater=carregarDados;
	function carregarDados(caminhoRetorno,idResposta,metodo,mensagem) {

	var ResultadosAJAX=document.getElementById(idResposta)
	ResultadosAJAX.innerHTML= mensagem;

	var xmlhttp = getXmlHttp();

	//Abre a url
	xmlhttp.open(metodo.toUpperCase(), caminhoRetorno,true);

	//Executada quando o navegador obtiver o código
	xmlhttp.onreadystatechange=function() {

		if (xmlhttp.readyState==4){
	
		//Lê o texto
		var texto=xmlhttp.responseText;
	
		//Desfaz o urlencode
		texto=texto.replace(/\+/g," ");
		texto=unescape(texto);
	
		//Exibe o texto no div conteúdo
	
		var ResultadosAJAX=document.getElementById(idResposta);
		ResultadosAJAX.innerHTML=texto;
		}
	}

xmlhttp.send(null);
}
}

function getXmlHttp() {
	var xmlhttp;
	try{
		xmlhttp = new XMLHttpRequest();
	}catch(ee){
		try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(E){
			xmlhttp = false;
			}
		}
	}
	return xmlhttp;
}

function recuperardatosPalabra() 
{
	var nome = document.BusqText.celular.value;	
	var ajax = new AJAX();
	ajax.Updater("buscar_ajax_palabra.php?palabra="+nome,"ResultadosAJAX","get","Cargando Datos...");
}


$(document).ready(function()
{
//Aquí buscamos todos los inputs que tengan una clase llamada; checkBoxGroup

//Ahora vamos hacer uso del Prototype de JS para digamos recorrer todo lo que se ha generado desde la variable a y lo devolvemos a la variable ids_
	
	$("#busqueda").click(function(){
        	$.get("buscar_ajax_boton.php", {palabra:document.BusqText.celular.value}, function(htmlexterno){
   $("#PanelMoviles").html(htmlexterno);
    		});
	});
	$("#BotonBusqAvan").click(function(){
		var ar_so=[];
		var ar_marca=[];
		var ar_tienda=[];
		var hola="MCMAOJPOANPAIN";

		$(':checkbox[name=so]').each(function() {
			if($(this).is(':checked')){
				ar_so.push($(this).val());
			}
            
        });
		$(':checkbox[name=marca]').each(function() {
			if($(this).is(':checked')){
				ar_marca.push($(this).val());
			}
            
        });
		$(':checkbox[name=tienda]').each(function() {
			if($(this).is(':checked')){
				ar_tienda.push($(this).val());
			}
            
        });
		ar_so=ar_so.toString();
		ar_marca=ar_marca.toString();
		ar_tienda=ar_tienda.toString();
		$.post("buscar_ajax_avanzado.php", {so:ar_so, marca:ar_marca, tienda:ar_tienda}, function(htmlexterno){
   $("#PanelMoviles").html(htmlexterno);
    		});
	});		
/* 		$.ajax({
 			url: "buscar_ajax_avanzado.php",
 			method: "POST",
 			data:{so:ar_so, marca: ar_marca, tienda: ar_tienda},
 			success:function(data){
 				$('#PanelMoviles').html(data);
 			}
 		});	*/							
	
});

function recuperardatosBoton() 
{
	var nome2 = document.BusqText.celular.value;
	var ajax = new AJAX();
	
	ajax.Updater("buscar_ajax_boton.php?palabra="+nome2,"PanelPrincipal","get","Cargando Datos...");
	
}

function recuperardatosAvanzado() 
{
	var nome = document.BusqText.celular.value;	
	var ajax = new AJAX();
	ajax.Updater("buscar_ajax_palabra.php?palabra="+nome,"ResultadosAJAX","get","Cargando Datos...");
}