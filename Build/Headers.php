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

class Headers
{

  public static function generate($params = NULL)
  {
    $headers = [
      'oauth_verifier' => self::get_param($params, 'oauth_verifier'),
      'oauth_callback' => self::get_param($params, 'oauth_callback'),
      'oauth_token' => Config::get('oauth_token'),
      'oauth_consumer_key' => Config::get('oauth_consumer_key'),
      'oauth_version' => '1.0',
      'oauth_timestamp' => time(),
      'oauth_nonce' => self::generate_nonce(),
      'oauth_signature_method' => 'HMAC-SHA1'
    ];
    return self::clean_headers($headers);
  }

  private static function clean_headers($headers)
  {
    foreach ( $headers as $key => $value )
    {
      if ( is_null($value) )
      {
        unset($headers[$key]);
      }
    }
    return $headers;
  }

  private static function get_param($params, $key)
  {
    return is_array($params) && count($params) > 0 && isset($params[$key]) ? $params[$key] : NULL;
  }

  private static function generate_nonce()
  {
    return substr(sha1(str_shuffle(__METHOD__)), 0, 10);
  }

}
