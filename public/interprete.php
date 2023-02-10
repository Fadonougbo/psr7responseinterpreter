<?php

namespace Psr7ResponseInterpreter;

require "./vendor/autoload.php";

use GuzzleHttp\Psr7\Response;

function interprete(Response $res)
{
  (new ResponseInterpreter)->send($res);
}

?>