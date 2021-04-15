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

use TradeMe\Helpers\Dates;

class BluRaySearch extends \TradeMe\HTTP\Resources
{

  private static $response;

  public function __construct($search = NULL)
  {
    $parameters = is_string($search) ? ['search' => $search] : NULL;
    $response = self::resource('get', '/bluray/find', $parameters);
    if ( $response->code() == 200 )
    {
      self::$response = $response->response();
      if ( isset(self::$response['PageSize']) && is_numeric(self::$response['PageSize']) && self::$response['PageSize'] > 0 && isset(self::$response['List']) && is_array(self::$response['List']) )
      {
        foreach ( self::$response['List'] as $i => $search_item )
        {
          if ( isset($search_item['ReleaseDate']) )
          {
            $search_item['ReleaseDate'] = Dates::convert_remove_timezone($search_item['ReleaseDate'], 'Y-m-d');
          }
          self::$response['List'][$i] = $search_item;
        }
      }
    }
  }

  public static function response()
  {
    return self::$response;
  }

}
