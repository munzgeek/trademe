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

namespace TradeMe\Resources\Catalogue;

class Categories extends \TradeMe\HTTP\Resources
{

  private static $response;

  public function __construct($array_categories = NULL)
  {
    $response = self::resource('get', self::get_path($array_categories), self::get_params($array_categories));
    if ( $response->code() == 200 )
    {
      self::$response = $response->response();
    }
  }

  public static function response()
  {
    return self::$response;
  }

  private static function get_params($categories_path)
  {
    if ( is_string($categories_path) && strlen($categories_path) > 0 && substr($categories_path, 0, 1) == '/' )
    {
      return [
        'mcat_path' => $categories_path
      ];
    }
  }

  private static function get_path($array_categories)
  {
    return '/Categories' . (is_string(self::filter_categories_request($array_categories)) ? ('/'.self::filter_categories_request($array_categories)) : NULL);
  }

  private static function filter_categories_request($array_categories)
  {
    $arr = [];
    if ( is_array($array_categories) && count($array_categories) > 0 )
    {
      foreach ( $array_categories as $category_id )
      {
        if ( is_numeric($category_id) && $category_id > 0 )
        {
          $id = intval($category_id);
          $arr[] = self::filled_zeros($id) . $id;
        }
      }
    }
    return is_array($arr) && count($arr) > 0 ? (implode('-', $arr).'-') : NULL;
  }

  private static function filled_zeros($id)
  {
    $length = strlen($id);
    if ( $length == 1 )
    {
      return '000';
    }
    else if ( $length == 2 )
    {
      return '00';
    }
    else if ( $length == 3 )
    {
      return '0';
    }
  }

}
