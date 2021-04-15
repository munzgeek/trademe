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

class Bid extends \TradeMe\HTTP\Resources
{

  private static $postfields;
  private static $response;

  public function __construct()
  {
    self::reset_all();
    self::auto_bid(false);
  }

  public static function listing_id($listing_id)
  {
    self::set_postfield('ListingId', $listing_id);
  }

  public static function auto_bid($auto_bid)
  {
    self::set_postfield('AutoBid', $auto_bid == true ? 1 : 0);
  }

  public static function amount($amount)
  {
    self::set_postfield('Amount', $amount);
  }

  public static function shipping_option($shipping_option)
  {
    self::set_postfield('ShippingOption', $shipping_option);
  }

  public static function email_outbid($email_outbid)
  {
    self::set_postfield('EmailOutBid', $email_outbid);
  }

  public static function firearms_licence($firearms_licence_id, $first_name, $last_name, $middle_name = NULL)
  {
    self::set_postfield('FirearmsLicence', $firearms_licence_id);
    self::set_postfield('FirearmsLicenceHolder', [
      'FirstName' => $first_name,
      'MiddleNames' => $middle_name,
      'LastName' => $last_name
    ]);
  }

  public static function is_buyer_older_than_18($is_buyer_older_than_18)
  {
    self::set_postfield('IsBuyerOlderThan18', $is_buyer_older_than_18 == true ? 1 : 0);
  }

  public static function return_listing_details($return_listing_details)
  {
    self::set_postfield('ReturnListingDetails', $return_listing_details == true ? 1 : 0);
  }

  public static function referring_search_query_id($referring_search_query_id)
  {
    self::set_postfield('ReferringSearchQueryId', $referring_search_query_id);
  }

  public static function process()
  {
    $response = self::resource('post', '/Bidding/Bid', self::$postfields);
    if ( $response->code() == 200 )
    {
      self::$response = $response->response();
    }
  }

  public static function response()
  {
    return self::$response;
  }

  private static function set_postfield($key, $value)
  {
    if ( is_null(self::$postfields) )
    {
      self::$postfields = [];
    }
    self::$postfields[$key] = $value;
  }

  private static function reset_all()
  {
    self::$postfields = NULL;
    self::$response = NULL;
  }

}
