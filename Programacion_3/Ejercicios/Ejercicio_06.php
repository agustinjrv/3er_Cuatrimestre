<?php
$operador=array("+","-","*","/");
$op1=rand();
$op2=rand();
$i=rand(0,3);
echo "Calculadora Automatica:<br/><br/>";

switch ($operador[$i]) 
{
    case '+':
        echo($op1 ." + " .$op2 . " = " . ($op1+$op2));
        
        break;
    case '-':
        echo($op1 ." - " .$op2 . " = " . ($op1-$op2));
    break;
    case '*':
        echo($op1 ." * " .$op2 . " = " . ($op1*$op2));

        break;
    case '/':

        echo($op1 ." / " .$op2 . " = " . ($op1/$op2));

    break;
}






?>
