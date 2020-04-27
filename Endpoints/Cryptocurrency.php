<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Endpoints;

use InvalidArgumentException;

/**
 * @link https://www.alphavantage.co/documentation/#digital-currency
 */
class Cryptocurrency implements Endpoint
{
    public const CRYPTO_CURRENCY_EXCHANGE_RATE = 'CURRENCY_EXCHANGE_RATE';
    public const CRYPTO_CURRENCY_DAILY = 'DIGITAL_CURRENCY_DAILY';
    public const CRYPTO_CURRENCY_WEEKLY = 'DIGITAL_CURRENCY_WEEKLY';
    public const CRYPTO_CURRENCY_MONTHLY = 'DIGITAL_CURRENCY_MONTHLY';

    private static array $validFunctions = [
        self::CRYPTO_CURRENCY_EXCHANGE_RATE,
        self::CRYPTO_CURRENCY_DAILY,
        self::CRYPTO_CURRENCY_MONTHLY,
        self::CRYPTO_CURRENCY_WEEKLY
    ];

    private string $function;

    /**
     * The currency you would like to get the exchange rate for.
     * It can either be a physical currency or digital/crypto currency.
     * For example: from_currency=USD or from_currency=BTC.
     * @see https://www.alphavantage.co/physical_currency_list/
     * @see https://www.alphavantage.co/digital_currency_list/
     */
    public ?string $from_currency;

    /**
     * The destination currency for the exchange rate.
     * It can either be a physical currency or digital/crypto currency.
     * For example: to_currency=USD or to_currency=BTC.
     * @see https://www.alphavantage.co/physical_currency_list/
     * @see https://www.alphavantage.co/digital_currency_list/
     */
    public ?string $to_currency;

    /**
     * he digital/crypto currency of your choice.
     * It can be any of the currencies in the digital currency list.
     * For example: symbol=BTC.
     * @see https://www.alphavantage.co/digital_currency_list/
     */
    public ?string $symbol;

    /**
     * The exchange market of your choice. It can be any of the market in the market list.
     * For example: market=CNY.
     * @see https://www.alphavantage.co/physical_currency_list/
     */
    public ?string $market;

    public function __construct(string $function)
    {
        if (!in_array($function, self::$validFunctions, true)) {
            throw new InvalidArgumentException(
                $function . ' is not valid, check https://www.alphavantage.co/documentation/
                for valid Cryptocurrency functions'
            );
        }
        $this->function = $function;
    }

    public function getQueryString(): string
    {
        return http_build_query($this);
    }
}
