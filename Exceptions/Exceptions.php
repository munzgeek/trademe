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

class Exceptions
{

  private static $exceptions;

  public static function set($code, $exception)
  {
    self::error($code, isset($exception['DeveloperDescription']) ? $exception['DeveloperDescription'] : NULL, isset($exception['Code']) ? $exception['Code'] : NULL, isset($exception['UserDescription']) ? $exception['UserDescription'] : NULL);
  }

  public static function set_error_description($code, $description)
  {
    self::error($code, $description);
  }

  public static function code()
  {
    return self::get_result('code');
  }

  public static function user_descirption()
  {
    return self::get_result('user_descirption');
  }

  public static function header_code()
  {
    return self::get_result('header_code');
  }

  public static function description()
  {
    return self::get_result('description');
  }

  private static function get_result($key)
  {
    return isset(self::$exceptions[$key]) ? self::$exceptions[$key] : NULL;
  }

  private static function error($header_code, $description, $code = NULL, $user_descirption = NULL)
  {
    self::$exceptions = [
      'code' => $code,
      'user_descirption' => $user_descirption,
      'header_code' => $header_code,
      'description' => $description
    ];
  }

}
