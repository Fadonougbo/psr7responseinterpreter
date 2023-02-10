<?php

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr7ResponseInterpreter\ResponseInterpreter;

class ResponseInterpreterTest extends TestCase
{
	public response $response;

	public ResponseInterpreter $responseInterpreter; 

	public  function setUp():void
	{
		$this->response=new Response(
			200,
			[ "Foo1"=>["x-foo1"],"Foo2"=>["x-foo2"] ],
			"demo");

		$this->responseInterpreter=new ResponseInterpreter();
	}

	public function test_interprete_Response_Headers()
	{

		$headersList=$this->response->getHeaders();

		$stringifyHeadersArray=$this->responseInterpreter->stringifyHeaders($headersList);

		$stringifyEmptyHeadersArray=$this->responseInterpreter->stringifyHeaders([]);

		$this->assertSame( ["Foo1:x-foo1","Foo2:x-foo2"],$stringifyHeadersArray );
		$this->assertSame( [],$stringifyEmptyHeadersArray );

		
	}
}

?>