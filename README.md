# Trade Me PHP API

An unofficial [Trade Me](https://www.trademe.co.nz/)'s PHP Client

## Initialize

    $trademe = new TradeMe\TradeMe([
        'oauth_consumer_key' => 'foo',
        'oauth_consumer_secret' => 'bar',
        'environment' => 'sandbox' // production or sandbox
    ]);

    if ( isset($_SESSION['access_token']) && isset($_SESSION['oauth_token_secret']) )
    {
        TradeMe\TradeMe::oauth_token($_SESSION['access_token']);
        TradeMe\TradeMe::oauth_token_secret($_SESSION['oauth_token_secret']);
    }

## Authorizing

#### Request Token (Step 1)

    $request_token = new TradeMe\OAuth\RequestToken(['MyTradeMeRead', 'MyTradeMeWrite', 'BiddingAndBuying']);
    $token = $request_token->response();

#### Authorize (Step 2)

    if ( is_array($token) )
    {
        $_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
        header('location: ' . $token['redirect_uri']);
    }

#### Access Token (Step 3)

    $access_token = isset($_GET['access_token']) ? $_GET['access_token'] : NULL;
    $oauth_token_secret = isset($_SESSION['oauth_token_secret']) ? $_SESSION['oauth_token_secret'] : NULL;
    $oauth_verifier = isset($_GET['oauth_verifier']) ? $_GET['oauth_verifier'] : NULL;
    
    TradeMe\TradeMe::oauth_token($access_token);
    TradeMe\TradeMe::oauth_token_secret($oauth_token_secret);
    
    $access_token = new TradeMe\OAuth\AccessToken($oauth_verifier);
    $token = $access_token->response();
    
    if ( is_array($token) )
    {
        $_SESSION['access_token'] = $token['access_token'];
        $_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
    }

## Testing

#### Access My Trade Me Summary (Using Get Method)

    $summary = new TradeMe\Resources\MyTradeMe\Summary;
    $arr = $summary->response();

#### Add Delivery Address (Using Post Method)

    $add_delivery_address = new TradeMe\Resources\MyTradeMe\DeliveryAddresses\Add([
        'name' => 'John Smith',
        'address_line_1' => '100 Janes Road',
        'city' => 'Queenstown',
        'postcode' => 9300
    ]);

    $delivery_address_id = $add_delivery_address->response();

#### Remove Delivery Address (Using Delete Method)

    $remove_delivery_address = new TradeMe\Resources\MyTradeMe\DeliveryAddresses\Remove($delivery_address_id);
    $results = $remove_delivery_address->response();
