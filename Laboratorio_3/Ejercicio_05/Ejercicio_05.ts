function MostrarNombreApellido(nombre:string,apellido:string)
{   var letra=nombre.charAt(0);
    nombre.replace(letra,letra.toLocaleUpperCase()); 
    console.log(apellido.toUpperCase() +"--"+ nombre);
}

MostrarNombreApellido("agustin","Rivola");