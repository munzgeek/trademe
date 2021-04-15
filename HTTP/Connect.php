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

use TradeMe\Exceptions;

class HTTP
{

  private static $request;
  private static $response;

  public function __construct($request)
  {
    self::set_request($request);
    self::api();
    self::check_exceptions();
  }

  public static function code()
  {
    return isset(self::$response['code']) && is_numeric(self::$response['code']) ? self::$response['code'] : 0;
  }

  public static function response()
  {
    return isset(self::$response['response']) ? self::$response['response'] : NULL;
  }

  private static function check_exceptions()
  {
    if ( self::is_json() && self::code() != 200 && isset(self::$response['response']['Error']) )
    {
      Exceptions::set(self::$response['code'], self::$response['response']['Error']);
    }
    else if ( self::is_json() && self::code() != 200 && isset(self::$response['response']['ErrorDescription']) )
    {
      Exceptions::set_error_description(self::$response['code'], self::$response['response']['ErrorDescription']);
    }
  }

  private static function api()
  {
    $curl_options = [
      CURLOPT_CONNECTTIMEOUT => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_VERBOSE => true,
      CURLOPT_URL => self::get_uri(),
      CURLOPT_HTTPHEADER => self::get_headers(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER => true,
      CURLOPT_USERAGENT => 'Code Attic Limited'
    ];
    if ( self::check_method('post') )
    {
      $curl_options[CURLOPT_POST] = true;
      if ( is_string(self::get_parameters()) )
      {
        $curl_options[CURLOPT_POSTFIELDS] = self::get_parameters();
      } else {
        $curl_options[CURLOPT_POSTFIELDS] = '&';
      }
    }
    else if ( self::check_method('delete') )
    {
      $curl_options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
    }
    $curl = curl_init();
    curl_setopt_array($curl, $curl_options);
    $response = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);
    self::set_response($code, $header_size, $response);
  }

  private static function set_response($code, $header_size, $response)
  {
    $headers = trim(substr($response, 0, $header_size));
    $data = trim(substr($response, $header_size));
    self::$response = [
      'code' => intval($code),
      'headers' => self::filter_response_headers($headers),
      'response' => self::is_json() ? json_decode($data, true) : $data
    ];
  }

  private static function filter_response_headers($headers)
  {
    $headers = explode("\n", $headers);
    $arr = [];
    foreach ( $headers as $header )
    {
      $e = explode(':', $header, 2);
      if ( count($e) == 2 )
      {
        $key = trim(strtolower($e[0]));
        $arr[$key] = trim($e[1]);
      }
    }
    return $arr;
  }

  private static function set_request($request)
  {
    self::$request = $request;
  }

  private static function get_parameters()
  {
    $method = strtolower(self::$request['method']);
    if ( $method == 'post' && isset(self::$request['parameters']) && is_array(self::$request['parameters']) && count(self::$request['parameters']) > 0 )
    {
      return self::is_json() ? json_encode(self::$request['parameters']) : http_build_query(self::$request['parameters']);
    }
  }

  private static function get_uri()
  {
    if ( isset(self::$request['method']) && isset(self::$request['uri']) )
    {
      $method = strtolower(self::$request['method']);
      if ( $method == 'get' || $method == 'delete' )
      {
        $uri = self::$request['uri'];
        if ( isset(self::$request['parameters']) && is_array(self::$request['parameters']) && count(self::$request['parameters']) > 0 )
        {
          if ( is_array(self::$request['parameters']) && count(self::$request['parameters']) > 0 )
          {
            $uri .= '?'.http_build_query(self::$request['parameters']);
          }
        }
        return $uri;
      }
      else if ( $method == 'post' )
      {
        return self::$request['uri'];
      }
    }
  }

  private static function get_headers()
  {
    $headers = [];
    if ( self::is_json() )
    {
      $headers[] = 'Content-Type: application/json';
    }
    if ( isset(self::$request['headers']) && is_array(self::$request['headers']) && count(self::$request['headers']) > 0 )
    {
      $headers[] = self::generate_oauth_headers();
    }
    if ( is_string(self::get_parameters()) )
    {
      $headers[] = 'Content-Length: '.(is_string(self::get_parameters()) ? strlen(self::get_parameters()) : 0);
    }
    return $headers;
  }

  private static function generate_oauth_headers()
  {
    $oauth = [];
    foreach ( self::$request['headers'] as $key => $value )
    {
      $oauth[] = $key . '="'.rawurlencode($value).'"';
    }
    sort($oauth);
    return 'Authorization: OAuth '.implode(', ', $oauth);
  }

  private static function is_json()
  {
    $is_json = true;
    if ( isset(self::$request['json']) && is_bool(self::$request['json']) && !self::$request['json'] )
    {
      $is_json = false;
    }
    return $is_json;
  }

  private static function check_method($method)
  {
    if ( isset(self::$request['method']) && strtolower(self::$request['method']) == strtolower($method) )
    {
      return true;
    }
  }

}
