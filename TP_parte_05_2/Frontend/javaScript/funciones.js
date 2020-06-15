///<reference path="../../node_modules/@types/jquery/index.d.ts" />
$(document).ready(function () {
    MostrarGrilla();
    
});

function MostrarGrilla() {
    var pagina = "../Backend/nuevaAdministracion.php";
    $.ajax({
        type: 'POST',
        url: pagina,
        data: { queHago: "mostrarGrilla" },
        dataType: "html",
        async: true
    })
        .done(function (retorno) {
        $("#divGrilla").html(retorno);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function AgregarEmpleado() {
    var pagina = "../Backend/nuevaAdministracion.php";
    var queHago = "agregar";
    var dni = $("#txtDni").val();
    var apellido = $("#txtApellido").val();
    var nombre = $("#txtNombre").val();
    var sexo = $("#cboSexo").val();
    var legajo = $("#txt_legajo").val();
    var sueldo = $("#txt_sueldo").val();
    var turno = $("#radTurno").val();
    //falta la foto
    var nuevoEmpleado = {};
    nuevoEmpleado.nombre = nombre;
    nuevoEmpleado.apellido = apellido;
    nuevoEmpleado.sexo = sexo;
    nuevoEmpleado.legajo = legajo;
    nuevoEmpleado.sueldo = sueldo;
    nuevoEmpleado.dni = dni;
    nuevoEmpleado.turno = turno;
    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            nuevoEmpleado: nuevoEmpleado,
            queHago: queHago
        },
        async: true
    })
        .done(function (objJson) {
        alert(objJson.mensaje);
        alert("estoy en el done");
        if (objJson.exito) {
            $("#txtDni").val("");
            $("#txtApellido").val("");
            $("#txtNombre").val("");
            $("#cboSexo").val("---");
            $("#txt_legajo").val("");
            $("#txt_sueldo").val("");
            $("#radTurno").val("Mañana");
            MostrarGrilla();
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert("estoy en el fall");
      //  alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function SubirFoto() {
    var pagina = "./administracion.php";
    var foto = $("#archivo").val();
    if (foto === "") {
        return;
    }
    var archivo = $("#archivo")[0];
    var formData = new FormData();
    formData.append("archivo", archivo.files[0]);
    formData.append("queHago", "subirFoto");
    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        async: true
    })
        .done(function (objJson) {
        if (!objJson.Exito) {
            alert(objJson.Mensaje);
            return;
        }
        $("#divFoto").html(objJson.Html);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function AdministrarValidaciones() {
    var dni = parseInt(document.getElementById("txtDni").value);
    var dniMin = parseInt(document.getElementById("txtDni").min);
    var dniMax = parseInt(document.getElementById("txtDni").max);
    AdministrarSpanError("spanDni", ValidarRangoNumerico(dni, dniMin, dniMax));
    AdministrarSpanError("spanApellido", (ValidarCamposVacios(document.getElementById("txtApellido").value)));
    AdministrarSpanError("spanNombre", ValidarCamposVacios(document.getElementById("txtNombre").value));
    var valorCorrecto = document.getElementById("cboSexo").value;
    AdministrarSpanError("spanSexo", ValidarCombo(valorCorrecto, "---"));
    var legajo = parseInt(document.getElementById("txt_legajo").value);
    var legajoMin = parseInt(document.getElementById("txt_legajo").min);
    var legajoMax = parseInt(document.getElementById("txt_legajo").max);
    AdministrarSpanError("spanLegajo", ValidarRangoNumerico(legajo, legajoMin, legajoMax));
    var sueldo = parseInt(document.getElementById("txt_sueldo").value);
    var sueldoMin = parseInt(document.getElementById("txt_sueldo").min);
    var turno = ObtenerTurnoSeleccionado();
    var sueldoMax = ObtenerSueldoMaximo(turno);
    AdministrarSpanError("spanSueldo", ValidarRangoNumerico(sueldo, sueldoMin, sueldoMax));
    AdministrarSpanError("spanFile", ValidarCamposVacios(document.getElementById("inputFile").value));
}
function VerificarValidacionesLogin() {
    var retorno = false;
    var cadena = document.getElementById("txtApellido").value;
    AdministrarSpanError("spanApellido", ValidarCamposVacios(cadena));
    var numero = parseInt(document.getElementById("txtDni").value);
    var min = parseInt(document.getElementById("txtDni").min);
    var max = parseInt(document.getElementById("txtDni").max);
    AdministrarSpanError("spanDni", ValidarRangoNumerico(numero, min, max));
    if (document.getElementById("spanDni").style.display == "none") {
        if (document.getElementById("spanApellido").style.display == "none") {
            retorno = true;
        }
    }
    return retorno;
}
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
    var radios = document.getElementsByTagName("input");
    var seleccionados = "";
    for (var index = 0; index < radios.length; index++) {
        var input = radios[index];
        if (input.type === "radio") {
            if (input.checked === true) {
                seleccionados += input.value + "-";
            }
        }
    }
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
function AdministrarSpanError(id, flag) {
    if (!flag) {
        document.getElementById(id).style.display = "block";
    }
    else {
        document.getElementById(id).style.display = "none";
    }
}
function AdministrarModificar(dni) {
    document.getElementById("hiddenDni").value = dni;
    var form = document.getElementById('formMostrar');
    form.submit();
}
