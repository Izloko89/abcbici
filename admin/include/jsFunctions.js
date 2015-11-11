function Alerta(texto,tipo)
{
	switch (tipo)
	{
		case 'Error': { Sexy.error('<h2>Error en el Sistema</h2><em>Panel de Administracion V.1.1</em><br/><p>' + texto + '</p>'); break; }
		case 'Alerta': { Sexy.alert('<h2>Alerta del Sistema</h2><em>Panel de Administracion V.1.1</em><br/><p>' + texto + '</p>'); break; }
		case 'Aviso': { Sexy.info('<h2>Aviso del Sistema</h2><em>Panel de Administracion V.1.1</em><br/><p>' + texto + '</p>'); }
	}
}

function Borrar(mod,id)
{
	Sexy.confirm("<h3>Confirmacion del Sistema</h3><em>Panel de Administracion V.1.1</em><br/><p>¿Estas seguro de querer Eliminar este registro?</p>", { onComplete: 
		function(returnvalue)
		{
			if(returnvalue)
            {
				window.location = "backend.php?mod=" + mod + "&acc=Borrar&ID=" + id;
			}
        }
	});
}

function Sube()
{
	window.document.getElementById('cargando').style.display = "block";
}

function CambiaEstatus(id)
{
	Sexy.confirm("<h3>Confirmacion del Sistema</h3><em>Panel de Administracion V.1.1</em><br/><p>¿Estas seguro de querer cambiar el estatus de este pedido?</p>", { onComplete: 
		function(returnvalue)
		{
			if(returnvalue)
            {
				document.getElementById('form' + id).submit();
			}
        }
	});
}

function SoloNumero(campo)
{
    var valor = campo.value;     
    var strLen = valor.length;
	if (!(/^[0-9.]+$/.test(valor))) { valor = valor.slice(0,strLen - 1); }
	campo.value = valor;
}