<?php

/*
  License
  ==============================================================================
  Copyright (C) 2021 Obrador Munsey Family Trust Limited
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:
  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.
  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
*/

$mapping = [
  'TradeMe\TradeMe' => __DIR__ . '/TradeMe.php',
  'TradeMe\Config' => __DIR__ . '/Config.php',
  'TradeMe\EndPoints' => __DIR__ . '/EndPoints.php',
  'TradeMe\Build\Headers' => __DIR__ . '/Build/Headers.php',
  'TradeMe\Build\Signature' => __DIR__ . '/Build/Signature.php',
  'TradeMe\HTTP' => __DIR__ . '/HTTP/Connect.php',
  'TradeMe\HTTP\Resources' => __DIR__ . '/HTTP/Resources.php',
  'TradeMe\Exceptions' => __DIR__ . '/Exceptions/Exceptions.php',
  'TradeMe\OAuth\RequestToken' => __DIR__ . '/OAuth/RequestToken.php',
  'TradeMe\OAuth\AccessToken' => __DIR__ . '/OAuth/AccessToken.php',
  // Examples of different methods (GET, POST, DELETE)
  'TradeMe\Resources\MyTradeMe\Summary' => __DIR__ . '/Resources/MyTradeMe/Summary.php',
  'TradeMe\Resources\MyTradeMe\DeliveryAddresses\Add' => __DIR__ . '/Resources/MyTradeMe/DeliveryAddresses/Add.php',
  'TradeMe\Resources\MyTradeMe\DeliveryAddresses\Remove' => __DIR__ . '/Resources/MyTradeMe/DeliveryAddresses/Remove.php'
];

if ( isset($mapping) && is_array($mapping) && count($mapping) > 0 )
{
	spl_autoload_register(function ($class) use ($mapping)
	{
		if (isset($mapping[$class]) )
		{
			require $mapping[$class];
		}
	}, true);
}
