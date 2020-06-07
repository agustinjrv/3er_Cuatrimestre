import {Empleado} from "../Empleado/Empleado.js";


export class Fabrica
{
    private _empleados: Empleado[] = [];
    private _razonSocial :string;
    

    public AgregarEmpleado(persona:Empleado):boolean
    {
        let retorno=true;
        this._empleados.forEach(e => {
            
            if(e.GetNombre()==persona.GetNombre() && e.GetApellido()==persona.GetApellido())
            {
            
                retorno=false;
            }
            
        });
        if(retorno)
        {
            this._empleados.push(persona);
        }


    
        return retorno;
    }

    public CalcularSueldos():number
    {
        let acumulador:number =0;

        this._empleados.forEach(e => {

            acumulador+=e.GetSueldo();

        });


        return acumulador;;
    }

    public constructor(razonSocial:string)
    {
        this._razonSocial=razonSocial;
    }

    public EliminarEmpleado(persona:Empleado):boolean
    {
        let retorno:boolean=false;
        let contador:number=0;
        this._empleados.forEach(e => {
            

            if(persona.GetApellido()==e.GetApellido() && persona.GetNombre()==e.GetNombre())
            {
                this._empleados.splice(contador,1);
                retorno=true;
            }
            contador++;
        });
        return retorno;
    }

    public ToString():string
    {
        let cadena:string="";
        cadena+="Razon Social: "+this._razonSocial+"\n"+
                "Sueldo Total: " + this.CalcularSueldos();
        this._empleados.forEach(e => {
            cadena+=e.ToString()+"\n";
        });

        return cadena;
    }




}