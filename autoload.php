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

$mapping = [
  'TradeMe\TradeMe' => __DIR__ . '/TradeMe.php',
  'TradeMe\Config' => __DIR__ . '/Config.php',
  'TradeMe\EndPoints' => __DIR__ . '/EndPoints.php',
  'TradeMe\Build\Headers' => __DIR__ . '/Build/Headers.php',
  'TradeMe\Build\Signature' => __DIR__ . '/Build/Signature.php',
  'TradeMe\HTTP' => __DIR__ . '/HTTP/Connect.php',
  'TradeMe\HTTP\Resources' => __DIR__ . '/HTTP/Resources.php',
  'TradeMe\Exceptions' => __DIR__ . '/Exceptions/Exceptions.php',
  'TradeMe\Helpers\Dates' => __DIR__ . '/Helpers/Dates.php',
  'TradeMe\OAuth\RequestToken' => __DIR__ . '/OAuth/RequestToken.php',
  'TradeMe\OAuth\AccessToken' => __DIR__ . '/OAuth/AccessToken.php',
  'TradeMe\Resources\Catalogue\Categories' => __DIR__ . '/Resources/Catalogue/Categories.php',
  'TradeMe\Resources\Catalogue\AttributeSuggestions' => __DIR__ . '/Resources/Catalogue/AttributeSuggestions.php',
  'TradeMe\Resources\Catalogue\UsedCarsMake' => __DIR__ . '/Resources/Catalogue/UsedCarsMake.php',
  'TradeMe\Resources\Catalogue\MotorBikes' => __DIR__ . '/Resources/Catalogue/MotorBikes.php',
  'TradeMe\Resources\Catalogue\Jobs' => __DIR__ . '/Resources/Catalogue/Jobs.php',
  'TradeMe\Resources\Catalogue\LastUpdated' => __DIR__ . '/Resources/Catalogue/LastUpdated.php',
  'TradeMe\Resources\Catalogue\CategoryDetails' => __DIR__ . '/Resources/Catalogue/CategoryDetails.php',
  'TradeMe\Resources\Catalogue\CategoryDetails\ByPath' => __DIR__ . '/Resources/Catalogue/CategoryDetailsByPath.php',
  'TradeMe\Resources\Catalogue\Localities' => __DIR__ . '/Resources/Catalogue/Localities.php',
  'TradeMe\Resources\Catalogue\Districts' => __DIR__ . '/Resources/Catalogue/Districts.php',
  'TradeMe\Resources\Catalogue\Suburbs' => __DIR__ . '/Resources/Catalogue/Suburbs.php',
  'TradeMe\Resources\Catalogue\IndividualSuburb' => __DIR__ . '/Resources/Catalogue/IndividualSuburb.php',
  'TradeMe\Resources\Catalogue\TradeMeAreas' => __DIR__ . '/Resources/Catalogue/TradeMeAreas.php',
  'TradeMe\Resources\Catalogue\TravelAreas' => __DIR__ . '/Resources/Catalogue/TravelAreas.php',
  'TradeMe\Resources\Catalogue\DvdValidation' => __DIR__ . '/Resources/Catalogue/DvdValidation.php',
  'TradeMe\Resources\Catalogue\BluRayValidation' => __DIR__ . '/Resources/Catalogue/BluRayValidation.php',
  'TradeMe\Resources\Catalogue\DvdSearch' => __DIR__ . '/Resources/Catalogue/DvdSearch.php',
  'TradeMe\Resources\Catalogue\BluRaySearch' => __DIR__ . '/Resources/Catalogue/BluRaySearch.php',
  'TradeMe\Resources\Catalogue\ComplaintSubjects' => __DIR__ . '/Resources/Catalogue/ComplaintSubjects.php',
  'TradeMe\Resources\Catalogue\CustomerSupportEnquirySubjects' => __DIR__ . '/Resources/Catalogue/CustomerSupportEnquirySubjects.php',
  'TradeMe\Resources\Catalogue\SiteStats' => __DIR__ . '/Resources/Catalogue/SiteStats.php',
  'TradeMe\Resources\Catalogue\SearchOptions' => __DIR__ . '/Resources/Catalogue/SearchOptions.php',
  'TradeMe\Resources\Catalogue\SearchOptions\Localities' => __DIR__ . '/Resources/Catalogue/SearchOptionsLocalities.php',
  'TradeMe\Resources\Catalogue\TopSellerCriteria' => __DIR__ . '/Resources/Catalogue/TopSellerCriteria.php',
  'TradeMe\Resources\Catalogue\InTradeReasons' => __DIR__ . '/Resources/Catalogue/InTradeReasons.php',
  'TradeMe\Resources\Catalogue\SearchPromotions' => __DIR__ . '/Resources/Catalogue/SearchPromotions.php',
  'TradeMe\Resources\Catalogue\Charities' => __DIR__ . '/Resources/Catalogue/Charities.php',
  'TradeMe\Resources\MyTradeMe\Summary' => __DIR__ . '/Resources/MyTradeMe/Summary.php',
  'TradeMe\Resources\MyTradeMe\DeliveryAddresses\Add' => __DIR__ . '/Resources/MyTradeMe/DeliveryAddresses/Add.php',
  'TradeMe\Resources\MyTradeMe\DeliveryAddresses\Remove' => __DIR__ . '/Resources/MyTradeMe/DeliveryAddresses/Remove.php'
];

if ( isset($mapping) && is_array($mapping) && count($mapping) > 0 )
{
	spl_autoload_register(function ($class) use ($mapping)
	{
		if (isset($mapping[$class]) )
		{
			require $mapping[$class];
		}
	}, true);
}
