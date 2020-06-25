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
    var Mascota = /** @class */ (function () {
        function Mascota(_tamaño, _edad, _precio) {
            this.tamaño = _tamaño;
            this.edad = _edad;
            this.precio = _precio;
        }
        Mascota.prototype.ToString = function () {
            var cadena = { tamaño: this.tamaño, edad: this.edad, precio: this.precio };
            return JSON.stringify(cadena);
        };
        return Mascota;
    }());
    Entidades.Mascota = Mascota;
})(Entidades || (Entidades = {}));
/// <reference path="Mascota.ts" />
var Entidades;
(function (Entidades) {
    var Perro = /** @class */ (function (_super) {
        __extends(Perro, _super);
        function Perro(_tamaño, _edad, _precio, _nombre, _raza, _pathFoto) {
            var _this = _super.call(this, _tamaño, _edad, _precio) || this;
            _this.nombre = _nombre;
            _this.raza = _raza;
            _this.pathFoto = _pathFoto;
            return _this;
        }
        Perro.prototype.ToJson = function () {
            var cadena = _super.prototype.ToString.call(this);
            var perroJson = JSON.parse(cadena);
            perroJson["nombre"] = this.nombre;
            perroJson["raza"] = this.raza;
            perroJson["pathFoto"] = this.pathFoto;
            return perroJson;
        };
        return Perro;
    }(Entidades.Mascota));
    Entidades.Perro = Perro;
})(Entidades || (Entidades = {}));
/// <reference path="./Perro.ts" />
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarPerroJSON = function () {
            var tamaño = $("#tamaño").val().toString();
            var edad = parseInt($("#edad").val().toString());
            var precio = parseFloat($("#precio").val().toString());
            var nombre = $("#nombre").val().toString();
            var raza = $("#raza").val().toString();
            var pagina = "./BACKEND/agregar_json.php";
            var path = $("#foto").val().toString();
            var foto = $("#foto")[0];
            var form = new FormData();
            var unPerro = new Entidades.Perro(tamaño, edad, precio, nombre, raza, path);
            var cadenaJson = JSON.stringify(unPerro.ToJson());
            form.append("caso", "agregar");
            form.append("cadenaJson", cadenaJson);
            form.append("foto", foto.files[0]);
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
                alert(respuesta.ok);
                unPerro.pathFoto = respuesta.pathFoto;
            }).fail(function () {
                console.log("error,ajax");
            });
        };
        Manejadora.MostrarPerrosJSON = function () {
            var pagina = "./BACKEND/traer_json.php";
            $.ajax({
                url: pagina,
                type: "post",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                async: true
            }).done(function (respuesta) {
                // tamaño,edad,precio,nombre,raza,path
                var cadena = "<table>";
                respuesta.forEach(function (element) {
                    cadena += "<tr>";
                    cadena += "<td>" + element.tamaño + "<td/>";
                    cadena += "<td>" + element.edad + "<td/>";
                    cadena += "<td>" + element.precio + "<td/>";
                    cadena += "<td>" + element.nombre + "<td/>";
                    cadena += "<td>" + element.raza + "<td/>";
                    cadena += "<td>" + ' <img src="./BACKEND/fotos/' + element.pathFoto + '" height="50px" width="50px" /> ' + "<td/>";
                    cadena += "<tr/>";
                });
                $("#divTabla").html(cadena);
            }).fail(function () {
                console.log("error,ajax");
            });
        };
        Manejadora.AgregarPerroEnBaseDatos = function () {
            var tamaño = $("#tamaño").val().toString();
            var edad = parseInt($("#edad").val().toString());
            var precio = parseFloat($("#precio").val().toString());
            var nombre = $("#nombre").val().toString();
            var raza = $("#raza").val().toString();
            var pagina = "./BACKEND/agregar_bd.php";
            var path = $("#foto").val().toString();
            var foto = $("#foto")[0];
            var form = new FormData();
            var unPerro = new Entidades.Perro(tamaño, edad, precio, nombre, raza, path);
            var cadenaJson = JSON.stringify(unPerro.ToJson());
            form.append("cadenaJson", cadenaJson);
            form.append("foto", foto.files[0]);
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
                alert("ok: " + respuesta.ok + "\nbd: " + respuesta.bd);
                unPerro.pathFoto = respuesta.pathFoto;
            }).fail(function () {
                console.log("error,ajax");
            });
        };
        Manejadora.VerificarExistencia = function () {
            var tamaño = $("#tamaño").val().toString();
            var edad = parseInt($("#edad").val().toString());
            var precio = parseFloat($("#precio").val().toString());
            var nombre = $("#nombre").val().toString();
            var raza = $("#raza").val().toString();
            var path = $("#foto").val().toString();
            var foto = $("#foto")[0];
            var unPerro = new Entidades.Perro(tamaño, edad, precio, nombre, raza, path);
            var pagina = "./BACKEND/traer_bd.php";
            $.ajax({
                url: pagina,
                type: "post",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                async: true
            }).done(function (respuesta) {
                var encontro = false;
                for (var i = 0; i < respuesta.length; i++) {
                    if (respuesta[i].edad == unPerro.edad && respuesta[i].raza == unPerro.raza) {
                        encontro = true;
                        break;
                    }
                }
                if (encontro) {
                    alert("El perro ya existe");
                    console.log("El perro ya existe");
                }
                else {
                    PrimerParcial.Manejadora.AgregarPerroEnBaseDatos();
                }
            }).fail(function () {
                console.log("error,ajax");
            });
        };
        Manejadora.MostrarPerrosBaseDatos = function () {
            var pagina = "./BACKEND/traer_bd.php";
            $.ajax({
                url: pagina,
                type: "post",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                async: true
            }).done(function (respuesta) {
                var cadena = "<table>";
                respuesta.forEach(function (element) {
                    cadena += "<tr>";
                    cadena += "<td>" + element.tamaño + "<td/>";
                    cadena += "<td>" + element.edad + "<td/>";
                    cadena += "<td>" + element.precio + "<td/>";
                    cadena += "<td>" + element.nombre + "<td/>";
                    cadena += "<td>" + element.raza + "<td/>";
                    cadena += "<td>" + ' <img src="./BACKEND/fotos/' + element.pathFoto + '" height="50px" width="50px" /> ' + "<td/>";
                    cadena += "<tr/>";
                });
                $("#divTabla").html(cadena);
            }).fail(function () {
                console.log("error,ajax");
            });
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
