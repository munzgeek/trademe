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

namespace TradeMe\Resources\Bidding;

class SendDeliveryAddress extends \TradeMe\HTTP\Resources
{

  private static $response;

  public function __construct($purchase_id, $delivery_address_id = NULL, $contact_phone_number = NULL, $message_to_seller = NULL, $return_listing_details = false)
  {
    $response = self::resource('post', '/Bidding/SendDeliveryAddress', self::params($purchase_id, $delivery_address_id, $contact_phone_number, $message_to_seller, $return_listing_details));
    if ( $response->code() == 200 )
    {
      self::$response = $response->response();
    }
  }

  public static function response()
  {
    return self::$response;
  }

  public static function params($purchase_id, $delivery_address_id, $contact_phone_number, $message_to_seller, $return_listing_details)
  {
    $parameters = [
      'PurchaseId' => $purchase_id,
      'DeliveryAddressId' => $delivery_address_id,
      'ContactPhoneNumber' => $contact_phone_number,
      'MessageToSeller' => $message_to_seller,
      'ReturnListingDetails' => is_bool($return_listing_details) && $return_listing_details ? 1 : 0
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

}
