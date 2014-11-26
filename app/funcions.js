//función md5login
//encripta o contrasinal do login antes de envialo
function md5login()
{
    //alert(document.forms["formLogin"].elements["inputContrasinal"].value + " - " + (hex_md5(document.forms["formLogin"].elements["inputContrasinal"].value)));
    if(document.forms["formLogin"].elements["inputContrasinal"].value != '')
        document.forms["formLogin"].elements["inputContrasinal"].value = (hex_md5(document.forms["formLogin"].elements["inputContrasinal"].value));
    //document.forms["formLogin"].submit();
}

//función md5rexistro
//encripta o contrasinal do rexistro antes de envialo
function md5rexistro()
{
    if(document.forms["formRexistro"].elements["inputContrasinalRexistro"].value != '')
        document.forms["formRexistro"].elements["inputContrasinalRexistro"].value = (hex_md5(document.forms["formRexistro"].elements["inputContrasinalRexistro"].value));
}

//función md5editar
//encripta o contrasinal de editar perfil antes de envialo
function md5editar()
{
    if(document.forms["formEditar"].elements["contrasinal"].value != '')
        document.forms["formEditar"].elements["contrasinal"].value = (hex_md5(document.forms["formEditar"].elements["contrasinal"].value));
}

//funcion cambiaPaxListado(p)
//ao navegar por un listado, envía o formulario de filtro coa nova páxina
function cambiaPaxListado(p)
{
    document.forms["formFiltro"].elements["p"].value = p;
    document.forms["formFiltro"].submit();
}

//función activarEdicionUsuario()
//habilita o formulario de edición de usuario
function activarEdicionUsuario()
{
    document.forms["formEditar"].elements["nome"].disabled = false;    
    document.forms["formEditar"].elements["contrasinal"].disabled = false;
    document.forms["formEditar"].elements["accion"].disabled = false;
    
    document.forms["formEditar"].elements["accion"].style.visibility = "visible";
    document.forms["formEditar"].elements["btnHabilitar"].style.visibility = "hidden";
    document.forms["formEditar"].elements["btnHabilitar"].disabled = true;
}

//función activarEdicionEquipo()
//habilita o formulario de edición de equipo
function activarEdicionEquipo()
{
    document.forms["formEditar"].elements["nome"].disabled = false;    
    document.forms["formEditar"].elements["codigo"].disabled = false;
    
    document.forms["formEditar"].elements["accion"].style.visibility = "visible";
    document.forms["formEditar"].elements["accion"].disabled = false;
    document.forms["formEditar"].elements["btnHabilitar"].style.visibility = "hidden";
    document.forms["formEditar"].elements["btnHabilitar"].disabled = true;
}

