var meses: string[] =["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

enum ListaMeses{"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"};
var i;

for(i=0;i<12;i++)
{
    console.log("Mes: "+ meses[i]+ "--- Es " + (i+1));
}


