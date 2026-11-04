import base64
import hashlib
import hmac
import json
import sqlite3
import sys
import time
import urllib.parse
import urllib.request


class RestApi:
    def __init__(self, cfg):
        self.url_domain = cfg.params['url_domain']
        self.credentials = cfg.params['credentials']
        self.user = cfg.params['user']
        self.api_key = ''
        self.api_sec = ''

    # -------------------------------------------------------------------------
    # Get Cred
    # -------------------------------------------------------------------------

    def get_credentials(self):
        connection = sqlite3.connect(self.credentials)
        cursor = connection.cursor()

        statement = 'SELECT value FROM entries WHERE ' + \
            f'key="Kraken API Key" AND attr1="{self.user}"'
        cursor.execute(statement)
        output = cursor.fetchone()
        self.api_key = output[0]

        statement = 'SELECT value FROM entries WHERE ' + \
            f'key="Kraken API Sec" AND attr1="{self.user}"'
        cursor.execute(statement)
        output = cursor.fetchone()
        self.api_sec = output[0]

        connection.close()

    # -------------------------------------------------------------------------
    # Authentication - API Signature
    # -------------------------------------------------------------------------

    def get_rapi_signature(self, rapi_path, data):
        encoded_data = (str(data['nonce']) +
                        urllib.parse.urlencode(data)).encode()
        message = rapi_path.encode() + hashlib.sha256(encoded_data).digest()
        mac = hmac.new(base64.b64decode(self.api_sec), message, hashlib.sha512)
        signature_digest = base64.b64encode(mac.digest())
        return signature_digest.decode()

    # -------------------------------------------------------------------------
    # Authentication - API Request
    # -------------------------------------------------------------------------

    def get_rapi_result(self, rapi_path, data=None):
        api_url = self.url_domain + rapi_path

        headers = {}
        headers['User-Agent'] = 'Kraken REST API Agent'
        headers['Content-Type'] = \
            'application/x-www-form-urlencoded; charset=utf-8'

        if data is not None:
            self.get_credentials()
            data = data | {'nonce': str(int(1000*time.time()))}
            headers['API-Key'] = self.api_key
            headers['API-Sign'] = self.get_rapi_signature(rapi_path, data)
            data = urllib.parse.urlencode(data).encode('ascii')

        url_request = urllib.request.Request(api_url, data, headers)
        with urllib.request.urlopen(url_request) as urllib_response:
            response = json.loads(urllib_response.read().decode())

        error = response['error']
        if error:
            sys.exit(f'{sys._getframe(1).f_code.co_name}: {error}\n')

        return response['result']

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - Server Time
    # -------------------------------------------------------------------------

    def get_server_time(self):
        rapi_path = '/0/public/Time'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - System Status
    # -------------------------------------------------------------------------

    def get_system_status(self):
        rapi_path = '/0/public/SystemStatus'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - Asset Info
    # -------------------------------------------------------------------------

    def get_asset_info(self, asset):
        rapi_path = f'/0/public/Assets?asset={asset}'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - Ticker Info
    # -------------------------------------------------------------------------

    def get_ticker_info(self, pair):
        rapi_path = f'/0/public/Ticker?pair={pair}'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - Order Book
    # -------------------------------------------------------------------------

    def get_order_book(self, pair):
        rapi_path = f'/0/public/Depth?pair={pair}&count=6'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - Recent Trades
    # -------------------------------------------------------------------------

    def get_recent_trades(self, pair):
        rapi_path = f'/0/public/Trades?pair={pair}'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Public Endpoints - Market Data - Recent Spreads
    # -------------------------------------------------------------------------

    def get_recent_spreads(self, pair):
        rapi_path = f'/0/public/Spread?pair={pair}'
        return self.get_rapi_result(rapi_path)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Account Balance
    # -------------------------------------------------------------------------

    def get_account_balance(self):
        rapi_path = '/0/private/Balance'
        data = {}
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Trade Balance
    # -------------------------------------------------------------------------

    def get_trade_balance(self, asset=None):
        rapi_path = '/0/private/TradeBalance?asset=ZEUR'
        data = {}
        if asset is not None:
            data['asset'] = asset
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Trade Volume
    # -------------------------------------------------------------------------

    def get_trade_volume(self, pair=None):
        rapi_path = '/0/private/TradeVolume'
        data = {}
        if pair is not None:
            data = {'pair': pair}
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Closed Orders
    # -------------------------------------------------------------------------

    def get_closed_orders(self):
        rapi_path = '/0/private/ClosedOrders'
        data = {}
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Order Info
    # -------------------------------------------------------------------------

    def get_order_info(self, txid):
        rapi_path = '/0/private/QueryOrders'
        data = {}
        data = {'txid': txid}
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Trades History
    # -------------------------------------------------------------------------

    def get_trades_history(self):
        rapi_path = '/0/private/TradesHistory'
        data = {}
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Ledgers Info
    # -------------------------------------------------------------------------

    def get_ledgers_info(self, asset=None):
        rapi_path = '/0/private/Ledgers'
        data = {}
        if asset is not None:
            data = {'asset': asset}
        return self.get_rapi_result(rapi_path, data)

    # -------------------------------------------------------------------------
    # Authenticated Endpoints - Query Ledgers
    # -------------------------------------------------------------------------

    def get_query_ledgers(self, ledger=None):
        rapi_path = '/0/private/QueryLedgers'
        data = {}
        if ledger is not None:
            data = {'id': ledger}
        return self.get_rapi_result(rapi_path, data)

# -----------------------------------------------------------------------------
