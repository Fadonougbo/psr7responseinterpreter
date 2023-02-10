<?php 

namespace Psr7ResponseInterpreter;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class ResponseInterpreter
{


	/**
	 * transform response headers array
	 * @param  array  $headerList [description]
	 * @return array          
	 */
	public function stringifyHeaders(array $headerList):array
	{
			$lists=[];

			if (!empty($headerList))
			{
				foreach ($headerList as $key => $value)
				{
					foreach ($value as $element)
					{
						$lists[]="$key:$element";
					}
				}
			}

			return $lists;
	}
	
	/**
	 * Show headers 
	 * @param  array    $headersList [description]
	 * @param  Response $response    [description]
	 * @return [type]                [description]
	 */
	private  function interpreteResponseHeaders(array $headersList,Response $response):void
	{
		$headers=$this->stringifyHeaders($headersList);

		$protocoleVersion=$response->getProtocolVersion();
		$statusCode=$response->getStatusCode();
		$reason=$response->getReasonPhrase();

     	header("HTTP/$protocoleVersion $statusCode $reason", true,$statusCode);

		foreach ($headers as $value)
		{
			header($value,false);
		}
	}

	/**
	 * Show body content
	 * @param   $body [description]
	 * @return [type]                [description]
	 */
	public function showBodyContent(StreamInterface $body):void
	{	
		if ($body->isSeekable())
		{
			$body->rewind();
		}

		if ($body->isReadable())
		{
			while(!$body->eof())
			{
				echo $body->read(1024*8);
			}
		}

	}

	/**
	 * [send description]
	 * @param  Response $response [description]
	 * @return [type]             [description]
	 */
	public function send(Response $response):void
	{
		$responseHeader=$response->getHeaders();
		$body=$response->getBody();

		$this->interpreteResponseHeaders($responseHeader,$response);
		$this->showBodyContent($body);
	}
}

?>