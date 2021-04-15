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

namespace TradeMe;

class TradeMe extends \TradeMe\Config
{

  public function __construct($config = NULL)
  {
    if ( is_array($config) && count($config) > 0 )
    {
      self::set_config_array($config);
    }
  }

  public static function environment($environment)
  {
    if ( $environment == 'production' || $environment == 'sandbox' )
    {
      self::set_config('environment', $environment);
    }
  }

  public static function sandbox()
  {
    self::environment('sandbox');
  }

  public static function production()
  {
    self::environment('production');
  }

  public static function oauth_consumer_key($oauth_consumer_key)
  {
    self::set_config('oauth_consumer_key', $oauth_consumer_key);
  }

  public static function oauth_consumer_secret($oauth_consumer_secret)
  {
    self::set_config('oauth_consumer_secret', $oauth_consumer_secret);
  }

  public static function oauth_token($oauth_token)
  {
    self::set_config('oauth_token', $oauth_token);
  }

  public static function oauth_token_secret($oauth_token_secret)
  {
    self::set_config('oauth_token_secret', $oauth_token_secret);
  }

  private static function set_config_array($config)
  {
    $keys = ['oauth_consumer_key', 'oauth_consumer_secret', 'oauth_token', 'oauth_token_secret', 'environment'];
    $environments = ['production', 'sandbox'];
    foreach ( $config as $key => $value )
    {
      if ( in_array($key, $keys) && $key != 'environment' )
      {
        self::set_config($key, $value);
      }
      else if ( in_array($key, $keys) && $key == 'environment' && in_array($value, $environments) )
      {
        self::set_config($key, $value);
      }
    }
  }

  private static function set_config($key, $value)
  {
    Config::set($key, $value);
  }

}
