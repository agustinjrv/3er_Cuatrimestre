
/// <reference path="MOCK_DATA.ts" />

let users = datos.MOCK_DATA;

//#1.-Mostrar todos los datos de los usuarios por consola
console.log("hola");
//console.log(users);
//#2.-Retornar todos los trabajos de los usuarios
let trabajos = users.map(function(usuario,index,array){
        return usuario.trabajo;
    });

//console.log(trabajos);

//#3.-Retornar todos los paises de los usuarios
let paises = users.map(function(usuario,index,array){
    return usuario.pais;
}) ;
//console.log(paises);

//#4.-Retornar un array de objetos de aquellos usuarios cuyo pais sea China
let chinas = users.filter(function(usuario,index,array){
    return usuario.pais=="China";
}) ;
//console.log(chinas);

//#5.-Retornar una array de objetos de todos los usuarios menores a 21 años
let jovenes = users.filter(function(usuario,index,array){
    return usuario.edad<21;
}) ;
//console.log(jovenes);


//#6.-Retornar la cantidad de usuarios con sexo masculino (Male)
let cantidadMasculinos = users.filter(function(usuario,index,array){
    return usuario.sexo=="Male";

}).length;
//console.log(cantidadMasculinos);


//#7.-Retornar una array de strings (el nombre de los usarios de sexo femenino (Female))
let nombresFemeninos = users.filter(function(usuario,index,array) {
    return usuario.sexo=="Female";
}).map(function(usuario,index,array){
    return usuario.nombre;
}) ;
//console.log(nombresFemeninos);

//#8.-Retornar una array de strings (el email de los usarios de sexo masculino (Male))
let mailsMasculinos = users.filter(function(usuario,index,array){
    return usuario.sexo=="Male";
}).map(function(usuario,index,array){
    return usuario.email;
});

//console.log(mailsMasculinos);

//#9.-Retornar un array de objetos que solo contengan los nombres, apellidos y ciudades de todos los usuarios
let datosUsers = users.map(function(usuario,index,array)
{
    let nuevoUsario:any={};
    nuevoUsario["nombre"]=usuario.nombre;
    nuevoUsario["apellido"]=usuario.apellido;
    nuevoUsario["ciudad"]=usuario.ciudad;
    return nuevoUsario;
});
//console.log(datosUsers);

//#10.-Retornar un array de objetos que solo contengan los nombres, apellidos y ciudades de todos los usuarios
// masculinos mayores de 35 años
let datosUsersMayoresMasculinos = users.filter(function(usuario,index,array){
    return usuario.sexo=="Male";
}).filter(function(usuario,index,array){
        return usuario.edad>35;
}).map(function(usuario,index,array){
    let retorno:any={};
    retorno["nombre"]=usuario.nombre;
    retorno["apellido"]=usuario.apellido;
    retorno["ciudad"]=usuario.ciudad;
    return retorno;
});
//console.log(datosUsersMayoresMasculinos);

//#11.-Retornar el promedio de edad de los usuarios
let promedioEdad = users.map(function(usuario,index,array){
    return usuario.edad;
}).reduce(function(anterior,siguiente,index,array)
{
    return anterior+ siguiente;
},0) / users.length;
//console.log(promedioEdad);  

//#12.-Retornar el promedio de edad de los usuarios masculinos
let edadesMasculinas=users.filter(function(usuario,index,array){
    return usuario.sexo=="Male";
}).map(function(usuario,index,array)
{
    return usuario.edad;
});
let promedioEdadMasculinos = edadesMasculinas.reduce(function(anterior,siguiente,index,array){
    return anterior + siguiente;
},0) / edadesMasculinas.length;

//console.log(promedioEdadMasculinos);  

//#13.-Retornar el promedio de edad de los usuarios egipcios (Egypt)
let promedioEdadEgipcios = function(){
    let edades=users.filter(function(usuario,index,array){
        return usuario.pais=="Egypt";
    }).map(function(usuario,index,array){
        return usuario.edad;
    });

    return edades.reduce(function(anterior,siguiente,index,array){
        return anterior +siguiente;
    },0) / edades.length;
};
console.log("Promedio edad Egipcios= "+promedioEdadEgipcios());  
console.log("FIN");
