<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Endpoints;

use InvalidArgumentException;
use function in_array;

/**
 * @link https://www.alphavantage.co/documentation/#time-series-data
 */
class StockTimeSeries implements Endpoint
{
    public const TIME_SERIES_INTRADAY = 'TIME_SERIES_INTRADAY';
    public const TIME_SERIES_DAILY = 'TIME_SERIES_DAILY';
    public const TIME_SERIES_DAILY_ADJUSTED = 'TIME_SERIES_DAILY_ADJUSTED';
    public const TIME_SERIES_WEEKLY = 'TIME_SERIES_WEEKLY';
    public const TIME_SERIES_WEEKLY_ADJUSTED = 'TIME_SERIES_WEEKLY_ADJUSTED';
    public const TIME_SERIES_MONTHLY = 'TIME_SERIES_MONTHLY';
    public const TIME_SERIES_MONTHLY_ADJUSTED = 'TIME_SERIES_MONTHLY_ADJUSTED';
    public const GLOBAL_QUOTE = 'GLOBAL_QUOTE';
    public const SYMBOL_SEARCH = 'SYMBOL_SEARCH';

    private static array $validFunctions = [
        self::TIME_SERIES_INTRADAY,
        self::TIME_SERIES_DAILY,
        self::TIME_SERIES_DAILY_ADJUSTED,
        self::TIME_SERIES_WEEKLY .
        self::TIME_SERIES_WEEKLY_ADJUSTED,
        self::TIME_SERIES_MONTHLY,
        self::TIME_SERIES_MONTHLY_ADJUSTED,
        self::GLOBAL_QUOTE,
        self::SYMBOL_SEARCH
    ];

    private string $function;

    /**
     * @see https://www.alphavantage.co/physical_currency_list/
     */
    private ?string $symbol;

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
    private string $interval;

    public function __construct(
        string $function,
        string $symbol = null,
        string $dataType = self::DATATYPE_JSON,
        string $outputsize = self::OUTPUTSIZE_COMPACT,
        string $interval = self::INTERVAL_5_MIN
    ) {
        if (!in_array($outputsize, [self::OUTPUTSIZE_COMPACT, self::OUTPUTSIZE_FULL], true)) {
            throw new InvalidArgumentException('Invalid outputsize given, valid values are: full, compact');
        }

        if ($dataType !== self::DATATYPE_JSON && $dataType !== self::DATATYPE_CSV) {
            throw new InvalidArgumentException($dataType . ' is not valid, try: csv or json');
        }

        if (!in_array($function, self::$validFunctions, true)) {
            throw new InvalidArgumentException(
                $function . ' is not valid, check https://www.alphavantage.co/documentation/ 
                for valid Stock Time Series functions'
            );
        }

        $this->outputsize = $outputsize;
        $this->dataType = $dataType;
        $this->function = $function;
        $this->symbol = $symbol;
        $this->interval = $interval;
    }

    public static function getValidFunctions(): array
    {
        return self::$validFunctions;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function getOutputsize(): string
    {
        return $this->outputsize;
    }

    public function getInterval(): string
    {
        return $this->interval;
    }

    public function getQueryString(): string
    {
        return http_build_query($this);
    }
}
