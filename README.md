# AlphaVantageBundle

[![Build Status](https://img.shields.io/travis/cHeeSaW/alpha-vantage-bundle)](https://travis-ci.com/cHeeSaW/alpha-vantage-bundle)
[![Quality](https://img.shields.io/scrutinizer/quality/g/cHeeSaW/alpha-vantage-bundle/master)](https://scrutinizer-ci.com/g/cHeeSaW/alpha-vantage-bundle/)
[![Coverage](https://img.shields.io/scrutinizer/coverage/g/cHeeSaW/alpha-vantage-bundle/master)](https://scrutinizer-ci.com/g/cHeeSaW/alpha-vantage-bundle/)
[![Dependencies](https://img.shields.io/librariesio/release/github/cheesaw/alpha-vantage-bundle)](https://libraries.io/github/cHeeSaW/alpha-vantage-bundle)
[![Maintainability](https://img.shields.io/codeclimate/maintainability/cHeeSaW/alpha-vantage-bundle)](https://codeclimate.com/github/cHeeSaW/alpha-vantage-bundle)

This bundle integrates the http://alphavantage.co/ Stock and Crypto API into Symfony 3/4/5.

## Requirements
- PHP 7.4+
- composer
- Alphavantage API-key, claim yours [here](https://www.alphavantage.co/support/#api-key)

## Installation
```
composer require cheesaw/alpha-vantage-bundle
```

## Setup
Set your API-key into an env var
```
CHEESAW_ALPHA_VANTAGE_API_KEY=YOUR-API-KEY
```

## Usage
Just use the client, it will be autowired by Symfony into your Services/Controllers
```php
/**
 * @Route("test/av/get", name="cheesaw_alphavantage_test")
 * @throws Exception
 */
public function alphaVantageTestAction(AlphaVantage $alphaVantageClient): Response
{
    $stockTimeSeries = new StockTimeSeries(StockTimeSeries::GLOBAL_QUOTE);
    $stockTimeSeries->symbol = 'BLDP';
    $response = $alphaVantageClient->get($stockTimeSeries);
    return new Response($response);
}
``` 
The code will output json:
```json
{ "Global Quote": { "01. symbol": "BLDP", "02. open": "10.6200", "03. high": "10.9800", "04. low": "10.4500", "05. price": "10.9300", "06. volume": "1086884", "07. latest trading day": "2020-02-06", "08. previous close": "10.6300", "09. change": "0.3000", "10. change percent": "2.8222%" } }
```

## Contributing
1. Fork this repository
2. Write your code
3. Create a new pull request

## FAQ
On any questions, send me a message!

## License
 
 [![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)
 
 - **[MIT license](http://opensource.org/licenses/mit-license.php)**
 - Copyright 2020 © <a href="https://github.com/cHeeSaW" target="_blank">Martin Tomala</a>.