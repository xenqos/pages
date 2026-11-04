<?php
#--------------------------------------------------------------------------------------------------
# Get API Key & Sec
#--------------------------------------------------------------------------------------------------

function get_apis()
{
  $user = $GLOBALS['user'];
  $apis = $GLOBALS['apis'];

  foreach(file($apis) as $line)
  {
    $fields = explode('|', $line);

    if ((trim($fields[0]) == $user) && (trim($fields[1]) == 'Key'))
    {
      $api_key = trim($fields[2]);
    }
    elseif  ((trim($fields[0]) == $user) && (trim($fields[1]) == 'Sec'))
    {
      $api_sec = trim($fields[2]);
    }
  }

  return [$api_key, $api_sec];
}

#--------------------------------------------------------------------------------------------------
# Get Authentication
# HMAC-SHA512 of (URI path + SHA256(nonce + POST data)) and base64 decoded secret API key
#--------------------------------------------------------------------------------------------------

function get_authentication($path, $post, $api_sec)
{
  $message = $post['nonce'] . http_build_query($post, '', '&', PHP_QUERY_RFC3986);
  $message_digest = $path . hash('sha256', $message, true);
  $hash_key = base64_decode($api_sec);
  $api_sign = hash_hmac('sha512', $message_digest, $hash_key, true);
  $api_sign = base64_encode($api_sign);
  return $api_sign;
}

#--------------------------------------------------------------------------------------------------
# Get Kraken Response
#--------------------------------------------------------------------------------------------------

function get_response($path, $query = null, $post = null)
{
  $url = $GLOBALS['url'] . $path;

  if (! is_null($post))
  {
    list($api_key, $api_sec) = get_apis();

    $post['nonce'] = (string)floor(microtime(true) * 1000);
    $api_sign = get_authentication($path, $post, $api_sec);
    array_push($GLOBALS['http_header'], "API-Key: {$api_key}");
    array_push($GLOBALS['http_header'], "API-Sign: {$api_sign}");
  }

  $response = json_decode(get_url($url, query: $query, post: $post), true);

  if(! empty($response['error']))
  {
    debug("{$url}: {$response['error'][0]}", name: 'kraken');
    exit;
  }

  $result = $response['result'];

  # debug($result, type: 'p', name: 'test');

  return $result;
}

#--------------------------------------------------------------------------------------------------
# PUBLIC ENDPOINTS
#--------------------------------------------------------------------------------------------------

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - Server Time
#--------------------------------------------------------------------------------------------------

function get_server_time()
{
  $path = '/0/public/Time';
  $response = get_response($path);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - System Status
#--------------------------------------------------------------------------------------------------

function get_system_status()
{
  $path = '/0/public/SystemStatus';
  $response = get_response($path);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - Asset Info
#--------------------------------------------------------------------------------------------------

function get_asset_info($query)
{
  $path = '/0/public/Assets';
  # $query = ['asset' => 'XBT,USD'];
  $response = get_response($path, query: $query);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - Ticker Info
#--------------------------------------------------------------------------------------------------

function get_ticker_info($query)
{
  $path = '/0/public/Ticker';
  $response = get_response($path, query: $query);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - Order Book
#--------------------------------------------------------------------------------------------------

function get_order_book($query)
{
  $path = '/0/public/Depth';
  $response = get_response($path, query: $query);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - Recent Trades
#--------------------------------------------------------------------------------------------------

function get_recent_trades($query)
{
  $path = '/0/public/Trades';
  $response = get_response($path, query: $query);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Public Endpoints - Market Data - Recent Spreads
#--------------------------------------------------------------------------------------------------

function get_recent_spreads($query)
{
  $path = '/0/public/Spread';
  $response = get_response($path, query: $query);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# AUTHENTICATED  ENDPOINTS
#--------------------------------------------------------------------------------------------------

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Account Balance
#--------------------------------------------------------------------------------------------------

function get_account_balance()
{
  $path = '/0/private/Balance';
  $post = [];
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Trade Balance
#--------------------------------------------------------------------------------------------------

function get_trade_balance($post)
{
  $path = '/0/private/TradeBalance';
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Trades History
#--------------------------------------------------------------------------------------------------

function get_trades_history($post)
{
  $path = '/0/private/TradesHistory';
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Ledgers Info
#--------------------------------------------------------------------------------------------------

function get_ledgers_info($post)
{
  $path = '/0/private/Ledgers';
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Closed Orders
#--------------------------------------------------------------------------------------------------

function get_closed_orders($post)
{
  $path = '/0/private/ClosedOrders';
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Order Info
#--------------------------------------------------------------------------------------------------

function get_order_info($post)
{
  $path = '/0/private/QueryOrders';
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Trade Volume
#--------------------------------------------------------------------------------------------------

function get_trade_volume($post)
{
  $path = '/0/private/TradeVolume';
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
# Authenticated Endpoints - Query Ledgers
#--------------------------------------------------------------------------------------------------

function get_query_ledgers($post)
{
  $path = '/0/private/QueryLedgers';
  # $post = ['id' => $ledger];
  $response = get_response($path, post: $post);
  return $response;
}

#--------------------------------------------------------------------------------------------------
?>
