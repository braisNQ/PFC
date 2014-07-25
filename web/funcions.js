//función md5login
//encripta o contrasinal do login antes de envialo
function md5login()
{
	//alert(document.forms["formLogin"].elements["inputContrasinal"].value + " - " + (hex_md5(document.forms["formLogin"].elements["inputContrasinal"].value)));
	document.forms["formLogin"].elements["inputContrasinal"].value = (hex_md5(document.forms["formLogin"].elements["inputContrasinal"].value));
	//document.forms["formLogin"].submit();
}

//función md5rexistro
//encripta o contrasinal do rexistro antes de envialo
function md5rexistro()
{
	document.forms["formRexistro"].elements["inputContrasinalRexistro"].value = (hex_md5(document.forms["formRexistro"].elements["inputContrasinalRexistro"].value));
	//document.forms["formRexistro"].submit();
}

//funcion cambiaPaxListado(p)
//ao navegar por un listado, envía o formulario de filtro coa nova páxina
function cambiaPaxListado(p)
{
	document.forms["formFiltro"].elements["p"].value = p;
	document.forms["formFiltro"].submit();
}

