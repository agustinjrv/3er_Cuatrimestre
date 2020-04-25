function ValidarCamposVacios(cadena) {
    var retorno = false;
    var tam = cadena.length;
    if (tam > 0) {
        retorno = true;
    }
    return retorno;
}
function ValidarRangoNumerico(numero, minimo, maximo) {
    var retorno = false;
    if (numero >= minimo && numero <= maximo) {
        retorno = true;
    }
    return retorno;
}
function ValidarCombo(cadena, cadenaIncorrecta) {
    return cadena != cadenaIncorrecta;
}
function ObtenerTurnoSeleccionado() {
    //obtengo todos los inputs
    var radios = document.getElementsByTagName("input");
    var seleccionados = "";
    //recorro los inputs
    for (var index = 0; index < radios.length; index++) {
        var input = radios[index];
        if (input.type === "radio") { //verifico que sea un checkbox
            if (input.checked === true) { //verifico que este seleccionado
                seleccionados += input.value + "-";
            }
        }
    }
    //quito el ultimo guion (-)
    seleccionados = seleccionados.substr(0, seleccionados.length - 1);
    console.log(seleccionados);
    return seleccionados;
}
function ObtenerSueldoMaximo(cadena) {
    var retorno = 0;
    switch (cadena) {
        case "Mañana":
            retorno = 20000;
            break;
        case "Tarde":
            retorno = 18500;
            break;
        case "Noche":
            retorno = 25000;
            break;
    }
    return retorno;
}
function AdministrarValidaciones() {
    var cadenaDeError = "";
    var dni = parseInt(document.getElementById("txtDni").value);
    var dniMin = parseInt(document.getElementById("txtDni").min);
    var dniMax = parseInt(document.getElementById("txtDni").max);
    if (ValidarRangoNumerico(dni, dniMin, dniMax)) {
    }
    else {
        cadenaDeError += "Error,el DNI no valido,debe ser un numero entre: " + dniMin + " y " + dniMax;
    }
    if (ValidarCamposVacios(document.getElementById("txtApellido").value)) {
    }
    else {
        cadenaDeError += "\nError,el campo Apellido no puede estar vacio";
    }
    if (ValidarCamposVacios(document.getElementById("txtNombre").value)) {
    }
    else {
        cadenaDeError += "\nError,el campo Nombre no puede estar vacio";
    }
    var valorCorrecto = document.getElementById("cboSexo").value;
    var valorIncorrecto = "---";
    if (ValidarCombo(valorCorrecto, valorIncorrecto)) {
    }
    else {
        cadenaDeError += "\nError,no a seleccionado el sexo del empleado";
    }
    var legajo = parseInt(document.getElementById("txt_legajo").value);
    var legajoMin = parseInt(document.getElementById("txt_legajo").min);
    var legajoMax = parseInt(document.getElementById("txt_legajo").max);
    if (ValidarRangoNumerico(legajo, legajoMin, legajoMax)) {
    }
    else {
        cadenaDeError += "\nError el Legajo no es valido,debe ser un numero entre: " + legajoMin + " y " + legajoMax;
    }
    var sueldo = parseInt(document.getElementById("txt_sueldo").value);
    var sueldoMin = parseInt(document.getElementById("txt_sueldo").min);
    var turno = ObtenerTurnoSeleccionado();
    var sueldoMax = ObtenerSueldoMaximo(turno);
    if (ValidarRangoNumerico(sueldo, sueldoMin, sueldoMax)) {
    }
    else {
        cadenaDeError += "\nError,para el turno " + turno + " el sueldo debe ser un numero entre: " + sueldoMin + " y " + sueldoMax;
    }
    if (ValidarCamposVacios(cadenaDeError)) {
        alert(cadenaDeError);
        console.log(cadenaDeError);
    }
}
