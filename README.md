# COINQVEST SEP-6 Client (PHP)

This client communicates with COINQVEST's Stellar [SEP-6](https://github.com/stellar/stellar-protocol/blob/master/ecosystem/sep-0006.md) transfer server documented [here](https://www.coinqvest.com/en/sep6-api-docs). It lets you on- and off-ramp Bitcoin on the Stellar Network. This client is written in PHP but we also provide clients in [different programming languages](https://www.coinqvest.com/en/sep6-api-docs).

Read our [stellar.toml](https://www.coinqvest.com/.well-known/stellar.toml) to inspect available COINQVEST assets on the Stellar Network. At the time of writing we support wrapped Bitcoin and Litecoin. 

Requirements
------------
* PHP >=5.3.0
* cURL extension for PHP
* OpenSSL extension for PHP

Installation as Drop-In
-----------------------
Copy the contents of `src` into the include path of your project.

**Usage Client**
```php
include('SEP6Client.class.php');
$client = new SEP6Client();
```

## Examples

**Deposit Bitcoin onto Stellar**
```php
$response = $client->get('/deposit', array(
    'asset_code' => 'BTC',
    'account' => 'GDONUHZKLSYLDOZWR2TDW25GFXOBWCCKTPK34DLUVSOMFHLGURX6FNU6',
    'memo' => 'Sent via SEP-6',
    'memo_type' => 'text'
));
// $response->responseBody -> {"how":"bc1qj633nx575jm28smgcp3mx6n3gh0zg6ndr0ew23","id":"f2118ef4115642870638616a4372","eta":600,"min_amount":"0.00001","max_amount":"100.0000000","extra_info":{}}
```

Returns a Bitcoin deposit address alongside some additional context information documented [here](https://www.coinqvest.com/en/sep6#get-deposit). Bitcoin sent to the received deposit address is tokenized onto Stellar and sent to above account. The tokenized Bitcoin can be [sent and received](https://developers.stellar.org/docs/tutorials/send-and-receive-payments) on the Stellar Network, [exchanged](https://developers.stellar.org/docs/encyclopedia/path-payments) for other assets on the SDEX, or be deposited into Stellar's [liquidity pools](https://developers.stellar.org/docs/encyclopedia/liquidity-on-stellar-sdex-liquidity-pools).


**Withdraw Bitcoin from Stellar**
```php
$response = $client->get('/withdraw', array(
    'asset_code' => 'BTC',
    'dest' => 'bc1qj633nx575jm28smgcp3mx6n3gh0zg6ndr0ew23'
));
// $response->responseBody -> {"account_id":"GCQVEST7KIWV3KOSNDDUJKEPZLBFWKM7DUS4TCLW2VNVPCBGTDRVTEIT","memo_type":"text","memo":"010cdf0a41410d75b2797a6fa38f","id":"010cdf0a41410d75b2797a6fa38f","min_amount":"0.0005000","max_amount":"100.0000000","fee_fixed":0.0002,"fee_percent":0.2,"extra_info":{"message":"An amount above 100.0000000 will take longer to complete"}}
```

Returns a Stellar account and memo alongside some additional context information documented [here](https://www.coinqvest.com/en/sep6#get-withdraw). Tokenized Bitcoin sent to the given account is burned on the Stellar Network and released into the Bitcoin address given in the request.

## Documentation

Please inspect our [SEP-6 API docs](https://www.coinqvest.com/en/sep6-api-docs) or email us at service@coinqvest.com if you have questions.

Support and Feedback
--------------------
We'd love to hear your feedback. If you have specific problems or bugs with this SDK, please file an issue on GitHub. For general feedback and support requests please email service@coinqvest.com.

Contributing
------------

1. Fork it ( https://github.com/COINQVEST/sep6-client-php/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request
