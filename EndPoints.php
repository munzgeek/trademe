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

class EndPoints extends \TradeMe\Config
{

  public static function api($path)
  {
    if ( is_string(self::get_domain()) )
    {
      return 'https://api.'.self::get_domain().'/v1'.$path.'.json';
    }
  }

  public static function secure($path)
  {
    if ( is_string(self::get_domain()) )
    {
      return 'https://secure.'.self::get_domain().$path;
    }
  }

  private static function get_domain()
  {
    if ( is_string(Config::get('environment')) && Config::get('environment') == 'production' )
    {
      return 'trademe.co.nz';
    }
    else if ( is_string(Config::get('environment')) && Config::get('environment') == 'sandbox' )
    {
      return 'tmsandbox.co.nz';
    }
  }

}
