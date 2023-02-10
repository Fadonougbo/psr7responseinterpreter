<?php

use GuzzleHttp\Psr7\Response;

use function Psr7ResponseInterpreter\interprete;

require "./vendor/autoload.php";

$r=new Response(200,["Foo1"=>"x-foo1","Foo2"=>"x-foo2"],"tesdddddt" ) ;

interprete($r);


?>