var Entidades;
(function (Entidades) {
    var Empleado = /** @class */ (function () {
        function Empleado(_nombre, _apellido, _sexo, _legajo, _sueldo, _dni, _turno, _pathFoto) {
            this.nombre = _nombre;
            this.apellido = _apellido;
            this.sexo = _sexo;
            this.legajo = _legajo;
            this.sueldo = _sueldo;
            this.dni = _dni;
            this.turno = _turno;
            this.pathFoto = _pathFoto;
        }
        Empleado.prototype.ToString = function () {
            return this.nombre + " - " + this.apellido + " - " + this.sexo + " - " + this.legajo + " - " + this.sueldo + " - " + this.turno + " - " + this.pathFoto;
        };
        Empleado.prototype.ToJson = function () {
            var Json = {};
            Json["nombre"] = this.nombre;
            Json["apellido"] = this.apellido;
            Json["sexo"] = this.sexo;
            Json["legajo"] = this.legajo;
            Json["sueldo"] = this.sueldo;
            Json["dni"] = this.dni;
            Json["turno"] = this.turno;
            Json["pathFoto"] = this.pathFoto;
            return Json;
        };
        return Empleado;
    }());
    Entidades.Empleado = Empleado;
})(Entidades || (Entidades = {}));
///<reference path="../../node_modules/@types/jquery/index.d.ts" />
///<reference path="../Entidades/Empleado.ts" />
function AgregarEmpleado(queHago) {
    var pagina = "../Backend/Administracion.php";
    var nombre = ($("#txtNombre").val()).toString();
    var apellido = $("#txtApellido").val().toString();
    var sexo = $("#cboSexo").val().toString();
    var legajo = parseInt($("#txt_legajo").val().toString());
    var sueldo = parseFloat($("#txt_sueldo").val().toString());
    var dni = parseInt($("#txtDni").val().toString());
    var turno = $("#radTurno").val().toString();
    var foto = $("#foto")[0];
    var pathFoto = $("#foto").val().toString();
    var unEmpleado = new Entidades.Empleado(nombre, apellido, sexo, legajo, sueldo, dni, turno, pathFoto);
    var cadenaJson = JSON.stringify(unEmpleado.ToJson());
    var form = new FormData();
    form.append("foto", foto.files[0]);
    form.append("cadenaJson", cadenaJson);
    form.append("queHago", queHago);
    $.ajax({
        url: pagina,
        type: "post",
        dataType: "json",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (respuesta) {
        alert("estoy en el done");
        MostrarLista();
        $("#txtNombre").val("");
        $("#txtApellido").val("");
        $("#cboSexo").val("Masculino");
        $("#txt_legajo").val("");
        $("#txt_sueldo").val("");
        $("#txtDni").val("");
        $("#radTurno").val("Mañana");
        $("#foto").val("");
        $("#btnAgregar").val("Agregar");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function MostrarLista() {
    var pagina = "../Backend/Administracion.php";
    $.ajax({
        type: 'POST',
        url: pagina,
        data: { queHago: "Mostrar" },
        dataType: "json",
        async: true
    })
        .done(function (retorno) {
        var html = '<h2>Listado de Empleados</h2>';
        html += '<table alingn="center">';
        html += '<tr><td>Info</td></tr>';
        html += '<tr><td><hr></td></tr>';
        retorno.forEach(function (element) {
            var unEmpleado = new Entidades.Empleado(element.nombre, element.apellido, element.sexo, element.legajo, element.sueldo, element.dni, element.turno, element.pathFoto);
            var json = JSON.stringify(unEmpleado.ToJson());
            html += "<tr>" + "<td>" + unEmpleado.ToString() + "</td>";
            html += "<td>" + '<img src=../Backend/fotos/' + unEmpleado.pathFoto + 'width="90" height="90">' + "</td>";
            html += "<td>" + "<input type='button' value='Eliminar' onclick='EliminarEmpleado(" + unEmpleado.legajo + ")'>" + '</td>';
            html += "<td>" + "<input type='button' value='Modificar' onclick='ModificarEmpleado(" + json + ")'>" + '</td>';
            html += "</tr>";
        });
        html += "</table>";
        $("#divGrilla").html(html);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function EliminarEmpleado(legajo) {
    var pagina = "../Backend/Administracion.php";
    var queHago = "Eliminar";
    var form = new FormData();
    form.append("legajo", legajo.toString());
    form.append("queHago", queHago);
    $.ajax({
        url: pagina,
        type: "post",
        dataType: "text",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (respuesta) {
        alert(respuesta);
        MostrarLista();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ModificarEmpleado(unEmpleado) {
    $("#txtNombre").val(unEmpleado.nombre);
    $("#txtApellido").val(unEmpleado.apellido);
    $("#cboSexo").val(unEmpleado.sexo);
    $("#txt_legajo").val(unEmpleado.legajo);
    $("#txt_sueldo").val(unEmpleado.sueldo);
    $("#txtDni").val(unEmpleado.dni);
    $("#txtDni").attr("readonly", "readonly");
    $("#radTurno").val(unEmpleado.turno);
    $("#foto").attr("disabled", "disabled");
    $("#foto").attr("requiered", "");
    $("#btnAgregar").val("Modificar");
    $("#btnAgregar").attr("onclick", "AgregarEmpleado('Modificar')");
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
