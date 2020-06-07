import {Empleado} from "../Empleado/Empleado.js";
import {Fabrica} from "../Fabrica/Fabrica.js";

let empleado1=new Empleado(1000,10000,"Agustin","Rivola",42432112,"M");
let empleado2=new Empleado(1001,12000,"Paula","Sosa",41402212,"F");
let empleado3=new Empleado(1002,10000,"Santiago","Aguado",43221102,"M");
let empleado4=new Empleado(1003,10000,"Siles","Jazmin",41029292,"F");

console.log(empleado1.Hablar("Español"));

console.log("\n" + empleado1.ToString());

console.log("\n\n\n------------Pruebo clase fabrica----------\n\n\n");

let unaFabrica=new Fabrica("Autos");

unaFabrica.AgregarEmpleado(empleado1);
unaFabrica.AgregarEmpleado(empleado2);
unaFabrica.AgregarEmpleado(empleado3);
unaFabrica.AgregarEmpleado(empleado4);

console.log("\n"+"\n"+unaFabrica.ToString());

unaFabrica.EliminarEmpleado(empleado2);
unaFabrica.EliminarEmpleado(empleado3);

console.log("\n"+"\n"+unaFabrica.ToString());

