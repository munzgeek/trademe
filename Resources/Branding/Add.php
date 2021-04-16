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

namespace TradeMe\Resources\Branding;

use TradeMe\Helpers\ImageFileName;
use TradeMe\Helpers\ImageEncode;

class Add extends \TradeMe\HTTP\Resources
{

  private static $response;

  public function __construct($member_id, $image_type, $file_location)
  {
    $response = self::resource('post', '/Member/'.$member_id.'/BrandingImages', self::parameters($image_type, $file_location));
    if ( $response->code() == 200 )
    {
      self::$response = $response->response();
    }
  }

  public static function response()
  {
    return self::$response;
  }

  private static function parameters($image_type, $file_location)
  {
    $parameters = [
      'FileName' => ImageFileName::get($file_location),
      'BrandingImageType' => self::branding_image_type($image_type),
      'ImageData' => ImageEncode::encode($file_location, false)
    ];
    foreach ( $parameters as $key => $value )
    {
      if ( is_null($value) )
      {
        unset($parameters[$key]);
      }
    }
    return $parameters;
  }

  private static function branding_image_type($type)
  {
    $branding_image_type_list = ['Logo', 'Banner', 'Square'];
    $keys = [
      'Logo' => 1,
      'Banner' => 2,
      'Square' => 3
    ];
    foreach ( $branding_image_type_list as $key )
    {
      if ( $key == $type )
      {
        return $keys[$key];
      }
    }
  }

}
