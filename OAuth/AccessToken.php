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

namespace TradeMe\OAuth;

use TradeMe\EndPoints;
use TradeMe\Build\Headers;
use TradeMe\Build\Signature;
use TradeMe\HTTP;

class AccessToken
{

  private static $response;

  public function __construct($oauth_verifier)
  {
    $request = [
      'json' => false,
      'method' => 'post',
      'uri' => EndPoints::secure('/OAuth/AccessToken'),
      'headers' => Headers::generate(self::oauth_verifier($oauth_verifier))
    ];
    $request['headers']['oauth_signature'] = Signature::generate($request, true);
    $response = new HTTP($request);
    if ( $response->code() == 200 )
    {
      parse_str($response->response(), $matches);
      self::$response = [
        'oauth_token' => isset($matches['oauth_token']) ? $matches['oauth_token'] : NULL,
        'oauth_token_secret' => isset($matches['oauth_token_secret']) ? $matches['oauth_token_secret'] : NULL
      ];
    }
  }

  public static function response()
  {
    return self::$response;
  }

  private static function oauth_verifier($oauth_verifier)
  {
    if ( is_string($oauth_verifier) )
    {
      return [
        'oauth_verifier' => $oauth_verifier
      ];
    }
  }

}
