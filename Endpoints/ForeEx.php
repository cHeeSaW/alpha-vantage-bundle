<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Endpoints;

use InvalidArgumentException;

/**
 * @link https://www.alphavantage.co/documentation/#fx
 */
class ForeEx implements Endpoint
{
    public const FOREX_CURRENCY_EXCHANGE_RATE = 'CURRENCY_EXCHANGE_RATE';
    public const FOREX_FX_INTRADAY = 'FX_INTRADAY';
    public const FOREX_FX_DAILY = 'FX_DAILY';
    public const FOREX_FX_WEEKLY = 'FX_WEEKLY';
    public const FOREX_FX_MONTHLY = 'FX_MONTHLY';

    private static array $validFunctions = [
        self::FOREX_CURRENCY_EXCHANGE_RATE,
        self::FOREX_FX_INTRADAY,
        self::FOREX_FX_DAILY,
        self::FOREX_FX_WEEKLY,
        self::FOREX_FX_MONTHLY
    ];

    private static array $validIntervals = [
        self::INTERVAL_1_MIN,
        self::INTERVAL_5_MIN,
        self::INTERVAL_15_MIN,
        self::INTERVAL_30_MIN,
        self::INTERVAL_60_MIN
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
    private ?string $to_currenccy;

    /**
     * A three-letter symbol from the forex currency list.
     * @see https://www.alphavantage.co/physical_currency_list/
     */
    private ?string $from_symbol;

    /**
     * A three-letter symbol from the forex currency list.
     * @see https://www.alphavantage.co/physical_currency_list/
     */
    private ?string $to_symbol;

    /**
     * Time interval between two consecutive data points in the time series.
     * The following values are supported: 1min, 5min, 15min, 30min, 60min
     */
    private string $interval;

    /**
     * By default, datatype=json. Strings json and csv are accepted with the following specifications:
     * json returns the intraday time series in JSON format; csv returns the time series as a
     * CSV (comma separated value) file.
     */
    private string $dataType;

    /**
     * By default, outputsize=compact. Strings compact and full are accepted with the following specifications:
     * compact returns only the latest 100 data points in the intraday time series; full returns the full-length
     * intraday time series. The "compact" option is recommended if you would like to reduce the data size of
     * each API call.
     */
    private string $outputsize;

    public function __construct(
        string $function,
        string $from_currency = null,
        string $to_currenccy = null,
        string $from_symbol = null,
        string $to_symbol = null,
        string $dataType = self::DATATYPE_JSON,
        string $outputsize = self::OUTPUTSIZE_COMPACT,
        string $interval = self::INTERVAL_5_MIN
    ) {
        if ($dataType !== self::DATATYPE_JSON && $dataType !== self::DATATYPE_CSV) {
            throw new InvalidArgumentException($dataType . ' is not valid, try: csv or json');
        }

        if (!in_array($function, self::$validFunctions, true)) {
            throw new InvalidArgumentException(
                $function . ' is not valid, check https://www.alphavantage.co/documentation/ for valid Forex functions'
            );
        }

        if (!in_array($interval, self::$validIntervals, true)) {
            throw new InvalidArgumentException(
                $interval . ' is not valid, valid ones are: 1min, 5min, 15min, 30min, 60min'
            );
        }

        if (!in_array($outputsize, [self::OUTPUTSIZE_COMPACT, self::OUTPUTSIZE_FULL], true)) {
            throw new InvalidArgumentException('Invalid outputsize given, valid values are: full, compact');
        }

        $this->outputsize = $outputsize;
        $this->dataType = $dataType;
        $this->function = $function;
        $this->interval = $interval;
        $this->from_currency = $from_currency;
        $this->to_currenccy = $to_currenccy;
        $this->from_symbol = $from_symbol;
        $this->to_symbol = $to_symbol;
    }

    public static function getValidFunctions(): array
    {
        return self::$validFunctions;
    }

    public static function getValidIntervals(): array
    {
        return self::$validIntervals;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getFromCurrency(): ?string
    {
        return $this->from_currency;
    }

    public function getToCurrenccy(): ?string
    {
        return $this->to_currenccy;
    }

    public function getFromSymbol(): ?string
    {
        return $this->from_symbol;
    }

    public function getToSymbol(): ?string
    {
        return $this->to_symbol;
    }

    public function getInterval(): string
    {
        return $this->interval;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function getOutputsize(): string
    {
        return $this->outputsize;
    }

    public function getQueryString(): string
    {
        return http_build_query($this);
    }
}
