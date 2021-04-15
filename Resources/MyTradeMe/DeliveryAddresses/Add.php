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

namespace TradeMe\Resources\MyTradeMe\DeliveryAddresses;

class Add extends \TradeMe\HTTP\Resources
{

  private static $delivery_address_id;

  public function __construct($address = NULL)
  {
    $post = [];
    $list = ['name' => 'Name', 'address_line_1' => 'Address1', 'address_line_2' => 'Address2', 'suburb' => 'Suburb', 'city' => 'City', 'postcode' => 'Postcode', 'country' => 'Country', 'phone_number' => 'PhoneNumber', 'is_membership_address' => 'IsMembershipAddress'];
    if ( is_array($address) && count($address) > 0 )
    {
      foreach ( $address as $key => $value )
      {
        if ( isset($list[$key]) )
        {
          $name = $list[$key];
          $post[$name] = $value;
        }
      }
    }
    $response = self::resource('post', '/MyTradeMe/DeliveryAddresses', $post);
    if ( $response->code() == 200 )
    {
      $response = $response->response();
      self::$delivery_address_id = isset($response['DeliveryAddressId']) ? $response['DeliveryAddressId'] : NULL;
    }
  }

  public static function response()
  {
    return [
      'delivery_address_id' => self::$delivery_address_id
    ];
  }

}
