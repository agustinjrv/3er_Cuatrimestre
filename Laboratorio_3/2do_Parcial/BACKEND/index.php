<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Firebase\JWT\JWT;



require "./vendor/autoload.php";
require "./Clases/Auto.php";
require "./Clases/usuario.php";
require_once './Clases/AccesoDatos.php';
require './Clases/mw.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post("/usuarios",\Usuario::class . "::AgregoUno")->add(
        \MW::class . "::VerificarEnBdCorreo")->add(
        \MW::class . "::VerificarVaciosCorreoYClave")->add(
        \MW::class .":VerificarSeteoCorreoYClave");

$app->get("[/]",\Usuario::class . "::TraerTodos");


$app->post("[/]",\Auto::class . "::AgregoUno")->add(\MW::class . ":VerificarPrecioYColor");

$app->get("/autos",\Auto::class . "::TraerTodos");

$app->post("/login",\Usuario::class . "::Login")->add(
        \MW::class . ":VerficarEnBDCorreoYClave")->add(
        \MW::class . "::VerificarVaciosCorreoYClave")->add(
        \MW::class .":VerificarSeteoCorreoYClave");

$app->get("/login",\Usuario::class . "::VerificarToken");

$app->delete("[/]",\Auto::class . "::BorrarUno")->add(
                \MW::class ."::EsPropietario")->add(
                \MW::class ."::VerificarToken");

$app->put("/",\Auto::class . "::ModificarUno")->add(
        \MW::class ."::EsPropietario")->add(
        \MW::class ."::VerificarToken");        


$app->run();