/******************** AJAX **********************************/
function LoadContent(url, id)
{
	var asynchronous = new Asynchronous();
	asynchronous.complete = function(responseText, id) {
		document.getElementById(id).innerHTML = responseText;
	}
	var responseItem = document.getElementById(id)
    responseItem.innerHTML = '<center><img src="imagenes/loader.gif" /></center>';
    asynchronous.call(url, id);
}

function ajaxValida(ruta,divID,valor)
{
	var url = ruta + 'ajaxValida.php?mod=' + divID
	switch (divID)
	{
		case 'validaEmail': { url += '&email=' + valor; break; }
		case 'validaPassword': { var pass1 = document.getElementById('password').value; url += '&pass1=' + pass1 + '&pass2=' + valor; break; }
	}
	LoadContent(url, divID);
}

function ajaxEntregas(ruta,mod,id)
{
	var url = ruta + 'ajaxEntregas.php?mod=' + mod
	switch (mod)
	{
		case 'Agregar': { url += '&domicilio=' + document.getElementById('domicilio').value + '&colonia=' + document.getElementById('colonia').value + '&ciudad=' + document.getElementById('ciudad').value + '&estado=' + document.getElementById('estado').value + '&entreCalles=' + document.getElementById('entreCalles').value + '&cp=' + document.getElementById('cp').value; if (document.getElementById('ID') != null) { url += '&ID=' + document.getElementById('ID').value; } break; }
		case 'Seleccionar': { url += '&ID=' + id; break; }
		case 'Editar': { url += '&ID=' + id; break; }
		case 'Eliminar': { url += '&ID=' + id; break; }
	}
	LoadContent(url, 'divEntregas');
}

function ajaxFacturacion(ruta,mod,id)
{
	var url = ruta + 'ajaxFacturacion.php?mod=' + mod
	switch (mod)
	{
		case 'Agregar': { url += '&razonSocial=' + document.getElementById('razonSocial').value + '&rfc=' + document.getElementById('rfc').value + '&domicilio=' + document.getElementById('domicilio').value + '&colonia=' + document.getElementById('colonia').value + '&ciudad=' + document.getElementById('ciudad').value + '&estado=' + document.getElementById('estado').value + '&cp=' + document.getElementById('cp').value; if (document.getElementById('ID') != null) { url += '&ID=' + document.getElementById('ID').value; } break; }
		case 'Seleccionar': { url += '&ID=' + id; break; }
		case 'Editar': { url += '&ID=' + id; break; }
		case 'Eliminar': { url += '&ID=' + id; break; }
	}
	LoadContent(url, 'divFacturacion');
}
/******************** AJAX **********************************/

/******************** GENERALES **********************************/
function Alerta(texto,tipo)
{
	switch (tipo)
	{
		case 'Error': { Sexy.error('<h3>Error</h3><em>Catalogo Virtual Americanet 2.0</em><br/><p>' + texto + '</p>'); break; }
		case 'Alerta': { Sexy.alert('<h3>Alerta</h3><em>Catalogo Virtual Americanet 2.0</em><br/><p>' + texto + '</p>'); break; }
		case 'Aviso': { Sexy.info('<h3>Aviso del Sistema</h3><em>Catalogo Virtual Americanet 2.0</em><br/><p>' + texto + '</p>'); }
	}
}

function RemoveFromCart(ruta,id)
{
	Sexy.confirm("<h3>Confirmacion</h3><em>Catalogo Virtual Americanet 2.0</em><br/><p>¿Estas seguro de querer Eliminar este producto de tu carrito?</p>", { onComplete: 
		function(returnvalue)
		{
			if(returnvalue)
            {
				window.location = ruta + 'removeFromCart.php?ID=' + id;
			}
        }
	});
}

function Trim(cadena)
{
	cadena = cadena.replace(/^\s*|\s*$/g,"");
	return cadena;
}

function Valida(form,mod)
{
	var mensaje = 'Los campos marcados con * son requeridos';
	var enviar = true;
	switch (mod)
	{
		case "Registro":
		{
			if (Trim(form.email.value) == '') { form.email.style.background = '#f4e4a4'; form.email.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.password.value) == '') { form.password.style.background = '#f4e4a4'; form.password.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.nombre.value) == '') { form.nombre.style.background = '#f4e4a4'; form.nombre.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.contacto.value) == '') { form.contacto.style.background = '#f4e4a4'; form.contacto.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.telefono.value) == '') { form.telefono.style.background = '#f4e4a4'; form.telefono.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.movil.value) == '') { form.movil.style.background = '#f4e4a4'; form.movil.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.imagetext.value) == '') { form.imagetext.style.background = '#f4e4a4'; form.imagetext.style.border = '1px #9e0a14 solid'; enviar = false; }

			if (Trim(form.password.value) != Trim(form.cPassword.value)) { form.password.style.background = '#f4e4a4'; form.password.style.border = '1px #9e0a14 solid'; form.cPassword.style.background = '#f4e4a4'; form.cPassword.style.border = '1px #9e0a14 solid'; mensaje = 'Existe una diferencia entre la contraseña y si confirmacion'; enviar = false; }
			break;
		}
		case "EditaRegistro":
		{
			if (Trim(form.email.value) == '') { form.email.style.background = '#f4e4a4'; form.email.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.nombre.value) == '') { form.nombre.style.background = '#f4e4a4'; form.nombre.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.contacto.value) == '') { form.contacto.style.background = '#f4e4a4'; form.contacto.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.telefono.value) == '') { form.telefono.style.background = '#f4e4a4'; form.telefono.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.movil.value) == '') { form.movil.style.background = '#f4e4a4'; form.movil.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (form.cPass.checked)
			{
				if (Trim(form.password.value) == '') { form.password.style.background = '#f4e4a4'; form.password.style.border = '1px #9e0a14 solid'; enviar = false; }
				if (Trim(form.password.value) != Trim(form.cPassword.value)) { form.password.style.background = '#f4e4a4'; form.password.style.border = '1px #9e0a14 solid'; form.cPassword.style.background = '#f4e4a4'; form.cPassword.style.border = '1px #9e0a14 solid'; mensaje = 'Existe una diferencia entre la contraseña y si confirmacion'; enviar = false; }
			}
			break;
		}
		case "Contacto":
		{
			
			if (Trim(form.nombre.value) == '') { form.nombre.style.background = '#f4e4a4'; form.nombre.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.telefono.value) == '') { form.telefono.style.background = '#f4e4a4'; form.telefono.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.email.value) == '') { form.email.style.background = '#f4e4a4'; form.email.style.border = '1px #9e0a14 solid'; enviar = false; }
			if (Trim(form.mensaje.value) == '') { form.mensaje.style.background = '#f4e4a4'; form.mensaje.style.border = '1px #9e0a14 solid'; enviar = false; }
			break;
		}
	}
	if (enviar == false) {  Alerta(mensaje,'Error'); }
	return enviar;
}

function Actualiza(ruta,id,cantidad)
{
	setTimeout("document.location.href='" + ruta + "addToCart.php?mod=Editar&cantidad=" + cantidad + "&ID=" + id + "'",1500)
}
/******************** GENERALES **********************************/

/******************** DREAMWEAVER **********************************/
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
/******************** DREAMWEAVER **********************************/