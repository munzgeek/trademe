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

namespace TradeMe\Build;

use TradeMe\Config;

class Signature
{

  private static $parameters;
  private static $base;
  private static $secret;

  public static function generate($post, $set_params = false)
  {
    if ( isset($post['method']) && isset($post['uri']) )
    {
      if ( $set_params || ($set_params == false && $set_params && ($post['method'] == 'get' || $post['method'] == 'delete')) )
      {
        self::set_parameters(isset($post['parameters']) ? $post['parameters'] : NULL);
      }
      self::set_parameters(isset($post['headers']) ? $post['headers'] : NULL);
      self::filter_parameters();
      self::base($post['method'], $post['uri']);
      self::secret();
      return self::signature();
    }
  }

  private static function signature()
  {
    return base64_encode(hash_hmac('sha1', self::$base, self::$secret, true));
  }

  private static function secret()
  {
    self::$secret = implode('&', [Config::get('oauth_consumer_secret'), Config::get('oauth_token_secret')]);
  }

  private static function base($method, $uri)
  {
    self::$base = implode('&', [strtoupper($method), rawurlencode($uri), rawurlencode(implode('&', self::$parameters))]);
  }

  private static function filter_parameters()
  {
    $e = [];
    foreach ( self::$parameters as $key => $value )
    {
      if ( is_string($value) || is_numeric($value) )
      {
        $e[] = $key . '=' . rawurlencode($value);
      }
    }
    sort($e);
    self::$parameters = $e;
  }

  private static function set_parameters($parameters)
  {
    if ( is_array($parameters) && count($parameters) > 0 )
    {
      if ( is_null(self::$parameters) )
      {
        self::$parameters = [];
      }
      self::$parameters = array_merge(self::$parameters, $parameters);
    }
  }

}
