import {Persona} from "../Persona/persona.js";


export class Empleado extends Persona
{
    protected _legajo:number;
    protected _sueldo:number;

    public constructor(legajo:number,sueldo:number,nombre:string,apellido:string,dni:number,sexo:string)
    {
        super(nombre,apellido,dni,sexo);

        this._legajo=legajo;
        this._sueldo=sueldo;
    }

    public GetLegajo():number
    {
        return this._legajo;
    }

    public GetSueldo():number
    {
        return this._sueldo;
    }

    public Hablar(idioma:string):string
    {
        return "la persona habla :"+idioma;
    }

    public ToString()
    {
        return super.ToString() + " - " + this._legajo + " - "+ this._sueldo;
    }







}
