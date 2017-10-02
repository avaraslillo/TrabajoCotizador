function ConfirmarEliminacion(){
	var confirmar=confirm("¿Está seguro de que desea eliminar el móvil seleccionado?. Esta acción es irreversible");
	if(confirmar){
		return true;
	}
	else{
		return false;
	}
}

function ActivarDatos(num){
		var check=document.getElementsByName('DisponibilidadTienda[]')[num];			
		if(check.checked==true){			
			document.getElementsByName('Enlace[]')[num].disabled=false;
			document.getElementsByName('PrCLP[]')[num].disabled=false;					
		}
		if(check.checked==false){
			document.getElementsByName('Enlace[]')[num].disabled=true;
			document.getElementsByName('PrCLP[]')[num].disabled=true;					
		}		
		
	}
	
function ActivarDatosACT(num){	
		var check=document.getElementsByName('TiendaActiva[]')[num];			
		if(check.checked==true){			
			document.getElementsByName('EnlaceActivo[]')[num].disabled=false;
			document.getElementsByName('PrCLPActivo[]')[num].disabled=false;					
		}
		if(check.checked==false){
			document.getElementsByName('EnlaceActivo[]')[num].disabled=true;
			document.getElementsByName('PrCLPActivo[]')[num].disabled=true;					
		}		
		
	}
function ActivarDatosINACT(num){	
		var check=document.getElementsByName('TiendaNueva[]')[num];			
		if(check.checked==true){			
			document.getElementsByName('EnlaceNuevo[]')[num].disabled=false;
			document.getElementsByName('PrCLPNuevo[]')[num].disabled=false;					
		}
		if(check.checked==false){
			document.getElementsByName('EnlaceNuevo[]')[num].disabled=true;
			document.getElementsByName('PrCLPNuevo[]')[num].disabled=true;					
		}		
		
	}		

function mostrarTiendas(){
	var mostrar=document.getElementById('NuevasTiendas');
	mostrar.style.display=(mostrar.style.display=='none') ? 'block' : 'none';
	}
	
function cambiarImagen(ruta){
	var cambioimagen=document.getElementById('ImagenGrande');
	cambioimagen.src=ruta;
	var cambioEnlace=document.getElementById('ImgEnlace');
	cambioEnlace.href=ruta;
}

	