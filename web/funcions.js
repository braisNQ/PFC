//función md5login
//encripta o contrasinal do login antes de envialo
function md5login()
{
	alert(document.forms["formLogin"].elements["inputContrasinal"].value + " - " + (hex_md5(document.forms["formLogin"].elements["inputContrasinal"].value)));
	document.forms["formLogin"].elements["inputContrasinal"].value = (hex_md5(document.forms["formLogin"].elements["inputContrasinal"].value));
	document.forms["formLogin"].submit();
}
