<?php

use GuzzleHttp\Psr7\Response;

use function Psr7ResponseInterpreter\interprete;

require "./vendor/autoload.php";

$r=new Response(200,["foo"=>"x-foo"],"essai");

interprete($r);


?>