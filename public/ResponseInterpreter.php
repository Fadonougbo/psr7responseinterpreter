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
	private function stringifyHeaders(array $headerList):array
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
	 * 
	 * @param  Response $response    [description]
	 * @return [type]                [description]
	 */
	private  function interpreteResponseHeaders(Response $response):void
	{
		$headers=$this->stringifyHeaders($response->getHeaders());

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
	 * Show body contents
	 * @param   $body [description]
	 * @return [type]                [description]
	 */
	private function showBodyContent(StreamInterface $body):void
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
		$body=$response->getBody();

		$this->interpreteResponseHeaders($response);
		$this->showBodyContent($body);
	}
}

?>