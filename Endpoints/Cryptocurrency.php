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
     * @see https://www.alphavantage.co/physical_currency_list/
     * @see https://www.alphavantage.co/digital_currency_list/
     */
    private ?string $from_currency;

    /**
     * @see https://www.alphavantage.co/physical_currency_list/
     * @see https://www.alphavantage.co/digital_currency_list/
     */
    private ?string $to_currency;

    /**
     * @see https://www.alphavantage.co/digital_currency_list/
     */
    private ?string $symbol;

    /**
     * The exchange market of your choice. It can be any of the market in the market list.
     * For example: market=CNY.
     * @see https://www.alphavantage.co/physical_currency_list/
     */
    private string $market;

    public function __construct(
        string $function,
        string $from_currency = null,
        string $to_currency = null,
        string $symbol = null
    ) {
        if (!in_array($function, self::$validFunctions, true)) {
            throw new InvalidArgumentException(
                $function . ' is not valid, check https://www.alphavantage.co/documentation/
                for valid Cryptocurrency functions'
            );
        }

        $this->function = $function;
        $this->from_currency = $from_currency;
        $this->to_currency = $to_currency;
        $this->symbol = $symbol;
    }

    public function getQueryString(): string
    {
        return http_build_query($this);
    }
}
