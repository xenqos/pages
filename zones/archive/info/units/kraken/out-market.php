<?php
#--------------------------------------------------------------------------------------------------
# Start Page
#--------------------------------------------------------------------------------------------------

function out_start_page()
{
  $images = $GLOBALS['images'];
  $unit = $GLOBALS['unit'];
  $users = $GLOBALS['users'];
  $user = $GLOBALS['user'];

  ($user == '') ? $GLOBALS['user'] = $users[0] : null;

  $content = get_template("start-page");
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Switch User
#--------------------------------------------------------------------------------------------------

function out_switch_user()
{
  $input = $GLOBALS['input'];
  $users = $GLOBALS['users'];
  $prog = $GLOBALS['prog'];

  $content = '';

  if ($input == 'select')
  {
    $url = "{$prog}?varUser=";
    $tag = '';

    foreach($users as $user)
    {
      $tag .= <<<DOC
        <tr>
          <td><input class='clSelector' id='{$user}' name='nmRadio' type='radio'></td>
          <td>{$user}</td>
        </tr>\n
      DOC;
    }

    $content = get_template("switch-user");
    eval("\$content = \"{$content}\";");
  }

  return $content;
}

#--------------------------------------------------------------------------------------------------
# System Status
#--------------------------------------------------------------------------------------------------

function out_system_status()
{
  $result = get_system_status();

  $result['timestamp'] = str_replace('T', ' ', $result['timestamp']);
  $result['timestamp'] = str_replace('Z', ' ', $result['timestamp']);

  $tag = <<<DOC
    <td>{$result['status']}</td><td>{$result['timestamp']}</td>
  DOC;

  $content = get_template('action-system-status');
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Ticker Info
#--------------------------------------------------------------------------------------------------

function out_ticker_info()
{
  $input = $GLOBALS['input'];
  $dict_tickers = $GLOBALS['dict_tickers'];

  if ($input == 'select')
  {
    $prog = $GLOBALS['prog'];
    $user = $GLOBALS['user'];
    $url = "{$prog}?varUser={$user}&varAction=Ticker&varInput=";
    $tag = '';

    foreach($dict_tickers as $key => $value)
    {
      $tag .= <<<DOC
        <tr>
          <td><input class='clSelector' id='{$key}' type='radio' name='sl'></td>
          <td>{$value[0]}</td>
        </tr>\n
      DOC;
    }

    $content = get_template('select-ticker-info');
    eval("\$content = \"{$content}\";");
  }
  else
  {
    $query = ['pair' => $input];
    $result = get_ticker_info($query);

    $heading = $dict_tickers[$input][0];
    $decimals = $dict_tickers[$input][1];

    $tag_ask      = number_format($result[$input]['a'][0], $decimals);
    $tag_bid      = number_format($result[$input]['b'][0], $decimals);
    $tag_last     = number_format($result[$input]['c'][0], $decimals);

    $tag_open     = number_format($result[$input]['o'],    $decimals);

    $tag_t_low    = number_format($result[$input]['l'][0], $decimals);
    $tag_y_low    = number_format($result[$input]['l'][1], $decimals);

    $tag_t_high   = number_format($result[$input]['h'][0], $decimals);
    $tag_y_high   = number_format($result[$input]['h'][1], $decimals);

    $tag_t_trades = number_format($result[$input]['t'][0], $decimals);
    $tag_y_trades = number_format($result[$input]['t'][1], $decimals);

    $tag_t_volume = number_format($result[$input]['v'][0], $decimals);
    $tag_y_volume = number_format($result[$input]['v'][1], $decimals);

    $content = get_template('action-ticker-info');
    eval("\$content = \"{$content}\";");
  }

  return $content;
}

#--------------------------------------------------------------------------------------------------
# Order Book
#--------------------------------------------------------------------------------------------------

function out_order_book()
{
  $input = $GLOBALS['input'];
  $dict_tickers = $GLOBALS['dict_tickers'];

  if ($input == 'select')
  {
    $prog = $GLOBALS['prog'];
    $user = $GLOBALS['user'];
    $url = "{$prog}?varUser={$user}&varAction=Depth&varInput=";
    $tag = '';

    foreach($dict_tickers as $key => $value)
    {
      $tag .= <<<DOC
        <tr>
          <td><input class='clSelector' id='{$key}' type='radio' name='sl'></td>
          <td>{$value[0]}</td>
        </tr>\n
      DOC;
    }

    $content = get_template('select-order-book');
    eval("\$content = \"{$content}\";");
  }
  else
  {
    $order_book_count = $GLOBALS['order_book_count'];
    $query = ['pair' => $input, 'count' => $order_book_count];
    $result = get_order_book($query);

    $heading = $dict_tickers[$input][0];
    $decimals_price = $dict_tickers[$input][1];
    $decimals_volume = $dict_tickers[$input][2];

    $bids = $result[$input]['bids'];
    $asks = $result[$input]['asks'];

    $tag = '<pre>' . print_r($result[$input]['asks'], true) . '</pre>';
    $tag_b = '';
    $tag_a = '';

    foreach($bids as $value)
    {
      $price_b = number_format($value[0], $decimals_price);
      $volume_b = number_format($value[1], $decimals_volume);
      $time_b = date('H:i:s', $value[2]);

      $tag_b .= <<<DOC
        <tr>
          <td class='clRight'>$price_b</td>
          <td class='clRight'>{$volume_b}</td>
          <td class='clRight'>{$time_b}</td>
        </tr>\n
      DOC;
    }

    foreach($asks as $value)
    {
      $price_a = number_format($value[0], $decimals_price);
      $volume_a = number_format($value[1], $decimals_volume);
      $time_a = date('H:i:s', $value[2]);

      $tag_a .= <<<DOC
        <tr>
          <td class='clRight'>$price_a</td>
          <td class='clRight'>{$volume_a}</td>
          <td class='clRight'>$time_a</td>
        </tr>\n
      DOC;
    }

    $content = get_template('action-order-book');
    eval("\$content = \"{$content}\";");
  }

  return $content;
}

#----------------------------------------------------------------------------------------------------------------------
?>
