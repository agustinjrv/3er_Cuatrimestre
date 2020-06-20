var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Ropa = /** @class */ (function () {
        function Ropa(_codigo, _nombre, _precio) {
            this.codigo = _codigo;
            this.nombre = _nombre;
            this.precio = _precio;
        }
        Ropa.prototype.ropaToString = function () {
            var $unaRopa = { "codigo": this.codigo, "nombre": this.nombre, "precio": this.precio };
            return JSON.stringify($unaRopa);
        };
        return Ropa;
    }());
    Entidades.Ropa = Ropa;
})(Entidades || (Entidades = {}));
/// <reference path="./ropa.ts" />
var Entidades;
(function (Entidades) {
    var Campera = /** @class */ (function (_super) {
        __extends(Campera, _super);
        function Campera(_codigo, _nombre, _precio, _talle, _color) {
            var _this = _super.call(this, _codigo, _nombre, _precio) || this;
            _this.talle = _talle;
            _this.color = _color;
            return _this;
        }
        Campera.prototype.CamperaToJson = function () {
            var cadena;
            cadena = _super.prototype.ropaToString.call(this);
            var camperaJson = JSON.parse(cadena);
            camperaJson["talle"] = this.talle;
            camperaJson["color"] = this.color;
            return camperaJson;
        };
        return Campera;
    }(Entidades.Ropa));
    Entidades.Campera = Campera;
})(Entidades || (Entidades = {}));
///<reference path="./node_modules/@types/jquery/index.d.ts"/>
///<reference path="./campera.ts"/>
var Test;
(function (Test) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarCampera = function (caso) {
            var codigo = parseInt($("#txtCodigo").val().toString());
            var nombre = ($("#txtNombre").val()).toString();
            var talle = $("#txtTalle").val().toString();
            var precio = parseFloat($("#txtPrecio").val().toString());
            var color = $("#cboColores").val().toString();
            var pagina = "./BACKEND/administrar.php";
            var unaCampera = new Entidades.Campera(codigo, nombre, precio, talle, color);
            var cadenaJson = JSON.stringify(unaCampera.CamperaToJson());
            var form = new FormData();
            if (Test.Manejadora.AdministrarValidaciones(unaCampera.CamperaToJson())) {
                if (caso == "agregar") {
                    form.append("caso", caso);
                    form.append("cadenaJson", cadenaJson);
                    $.ajax({
                        type: "post",
                        url: pagina,
                        dataType: "json",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async: true
                    })
                        .done(function (resultado) {
                        alert(resultado["TodoOK"]);
                        Test.Manejadora.MostrarCampera();
                    })
                        .fail(function () {
                        alert("Error ajax");
                    });
                }
                else if (caso == "modificar") {
                    form.append("caso", caso);
                    form.append("cadenaJson", cadenaJson);
                    $.ajax({
                        type: "post",
                        url: pagina,
                        dataType: "json",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async: true
                    })
                        .done(function (resultado) {
                        alert(resultado["TodoOK"]);
                        Test.Manejadora.MostrarCampera();
                    })
                        .fail(function () {
                        alert("Error ajax");
                    })
                        .always(function () {
                        $("#btnAgregar").val("Agregar");
                        $("#btnAgregar").attr("onclick", 'Test.Manejadora.AgregarCampera("agregar")');
                    });
                }
                Test.Manejadora.LimpiarForm();
            }
        };
        Manejadora.MostrarCampera = function () {
            var form = new FormData();
            form.append("caso", "mostrar");
            var pagina = "./BACKEND/administrar.php";
            $.ajax({
                type: "post",
                url: pagina,
                dataType: "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async: true
            })
                .done(function (resultado) {
                var cadena = "<table>";
                var jsonString = "";
                resultado.forEach(function (element) {
                    jsonString = JSON.stringify(element);
                    cadena += "<tr>";
                    cadena += "<td> " + element.codigo + " </td>";
                    cadena += "<td> " + element.nombre + " </td>";
                    cadena += "<td> " + element.precio + " </td>";
                    cadena += "<td> " + element.talle + " </td>";
                    cadena += "<td> " + element.color + " </td>";
                    cadena += "<td><input type='button' value='Modificar' onclick='Test.Manejadora.ModificarCampera(" + jsonString + ")'><td/>";
                    cadena += "<td><input type='button' value='Eliminar' onclick='Test.Manejadora.EiminarCampera(" + jsonString + ")'><td/>";
                    cadena += "<tr/>";
                });
                cadena += "<table/>";
                $("#divTabla").html(cadena);
            })
                .fail(function () {
                alert("error ajax");
            });
        };
        Manejadora.EiminarCampera = function (json) {
            var pagina = "./BACKEND/administrar.php";
            var form = new FormData();
            form.append("caso", "eliminar");
            form.append("cadenaJson", JSON.stringify(json));
            var borrar = prompt("¿Desea eliminar la campera con codigo: " + json.codigo + " y Talle: " + json.talle +
                "?\n(ingrese 's' para continuar)").toLowerCase();
            if (borrar == "s") {
                $.ajax({
                    type: "post",
                    url: pagina,
                    dataType: "json",
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: true
                })
                    .done(function (resultado) {
                    alert(resultado["TodoOK"]);
                    Test.Manejadora.MostrarCampera();
                })
                    .fail(function () {
                    alert("Error ajax");
                });
                Test.Manejadora.LimpiarForm();
            }
        };
        Manejadora.ModificarCampera = function (json) {
            $("#txtCodigo").val(json.codigo);
            $("#txtCodigo").attr("readonly", "readonly");
            $("#txtNombre").val(json.nombre);
            $("#txtTalle").val(json.talle);
            $("#txtPrecio").val(json.precio);
            $("#cboColores").val(json.color);
            $("#btnAgregar").val("Modificar");
            $("#btnAgregar").attr("onclick", 'Test.Manejadora.AgregarCampera("modificar")');
        };
        Manejadora.FiltrarCamperasPorColor = function () {
            var form = new FormData();
            form.append("caso", "mostrar");
            var pagina = "./BACKEND/administrar.php";
            var color = $("#cboColores").val();
            $.ajax({
                type: "post",
                url: pagina,
                dataType: "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async: true
            })
                .done(function (resultado) {
                var cadena = "<table>";
                var jsonString = "";
                resultado.forEach(function (element) {
                    if (color == element.color) {
                        jsonString = JSON.stringify(element);
                        cadena += "<tr>";
                        cadena += "<td> " + element.codigo + " </td>";
                        cadena += "<td> " + element.nombre + " </td>";
                        cadena += "<td> " + element.precio + " </td>";
                        cadena += "<td> " + element.talle + " </td>";
                        cadena += "<td> " + element.color + " </td>";
                        cadena += "<td><input type='button' value='Modificar' onclick='Test.Manejadora.ModificarCampera(" + jsonString + ")'><td/>";
                        cadena += "<td><input type='button' value='Eliminar' onclick='Test.Manejadora.EiminarCampera(" + jsonString + ")'><td/>";
                        cadena += "<tr/>";
                    }
                });
                cadena += "<table/>";
                $("#divTabla").html(cadena);
            })
                .fail(function () {
                alert("error ajax");
            });
        };
        Manejadora.CarjarColoresJSON = function () {
            var form = new FormData();
            form.append("caso", "colores");
            var pagina = "./BACKEND/administrar.php";
            var listaColores = new Array();
            var cadena = "";
            $.ajax({
                type: "post",
                url: pagina,
                dataType: "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async: true
            })
                .done(function (resultado) {
                for (var i = 0; i < resultado.length; i++) {
                    var repetido = false;
                    for (var z = 0; z < listaColores.length; z++) {
                        if (listaColores[z].descripcion == resultado[i].descripcion) {
                            repetido = true;
                            break;
                        }
                    }
                    if (repetido == false) {
                        listaColores.push(resultado[i]);
                        cadena += '<option>' + resultado[i].descripcion + '</opcion>';
                    }
                }
                $('#cboColores').html(cadena);
            })
                .fail(function () {
                alert("error ajax");
            });
        };
        Manejadora.AdministrarValidaciones = function (campera) {
            var _a, _b;
            var arrayString = ["S", "M", "L", "X", "XL", "XX"];
            var retorno = true;
            if (!Test.Manejadora.ValidarCodigo(campera.codigo)) {
                $("#spanCodigo").attr("style", "display : block;");
                retorno = false;
            }
            else {
                $("#spanCodigo").attr("style", "display : none;");
            }
            if (!Test.Manejadora.ValidarCamposVacios(campera.nombre)) {
                $("#spanNombre").attr("style", "display : block;");
                retorno = false;
            }
            else {
                $("#spanNombre").attr("style", "display : none;");
            }
            if (!Test.Manejadora.ValidarTalles((_a = campera.talle) !== null && _a !== void 0 ? _a : "", arrayString)) {
                $("#spanTalle").attr("style", "display : block;");
                retorno = false;
            }
            else {
                $("#spanTalle").attr("style", "display : none;");
            }
            if (!Test.Manejadora.ValidarCamposVacios(((_b = campera.precio) !== null && _b !== void 0 ? _b : "").toString())) {
                $("#spanPrecio").attr("style", "display : block;");
                retorno = false;
            }
            else {
                $("#spanPrecio").attr("style", "display : none;");
            }
            return retorno;
        };
        Manejadora.ValidarCamposVacios = function (cadena) {
            var retorno = false;
            var tam = cadena.length;
            if (tam > 0) {
                retorno = true;
            }
            return retorno;
        };
        Manejadora.ValidarTalles = function (cadena, arrayString) {
            var retorno = false;
            for (var i = 0; i < arrayString.length; i++) {
                if (cadena.toUpperCase() == arrayString[i].toUpperCase()) {
                    retorno = true;
                    break;
                }
            }
            return retorno;
        };
        Manejadora.ValidarCodigo = function (codigo) {
            var retorno = false;
            if (codigo >= 523 && codigo < 1000) {
                retorno = true;
            }
            return retorno;
        };
        Manejadora.LimpiarForm = function () {
            $("#txtCodigo").val("");
            $("#txtCodigo").val("");
            $("#txtNombre").val("");
            $("#txtTalle").val("");
            $("#txtPrecio").val("");
            $("#cboColores").val("Azul");
        };
        return Manejadora;
    }());
    Test.Manejadora = Manejadora;
})(Test || (Test = {}));
