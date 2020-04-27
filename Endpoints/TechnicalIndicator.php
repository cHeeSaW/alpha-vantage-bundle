<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Endpoints;

use InvalidArgumentException;

/**
 * @link https://www.alphavantage.co/documentation/#technical-indicators
 */
class TechnicalIndicator implements Endpoint
{
    public const TI_SMA = 'SMA';
    public const TI_EMA = 'EMA';
    public const TI_WMA = 'WMA';
    public const TI_DEMA = 'DEMA';
    public const TI_TEMA = 'TEMA';
    public const TI_TRIMA = 'TRIMA';
    public const TI_KAMA = 'KAMA';
    public const TI_MAMA = 'MAMA';
    public const TI_VWAP = 'VWAP';
    public const TI_T3 = 'T3';
    public const TI_MACD = 'MACD';
    public const TI_MACDEXT = 'MACDEXT';
    public const TI_STOCH = 'STOCH';
    public const TI_STOCHF = 'STOCHF';
    public const TI_RSI = 'RSI';
    public const TI_STOCHRSI = 'STOCHRSI';
    public const TI_WILLR = 'WILLR';
    public const TI_ADX = 'ADX';
    public const TI_ADXR = 'ADXR';
    public const TI_APO = 'APO';
    public const TI_PPO = 'PPO';
    public const TI_MOM = 'MOM';
    public const TI_BOP = 'BOP';
    public const TI_CCI = 'CCI';
    public const TI_CMO = 'CMO';
    public const TI_ROC = 'ROC';
    public const TI_ROCR = 'ROCR';
    public const TI_AROON = 'AROON';
    public const TI_AROONOSC = 'AROONOSC';
    public const TI_MFI = 'MFI';
    public const TI_TRIX = 'TRIX';
    public const TI_ULTOSC = 'ULTOSC';
    public const TI_DX = 'DX';
    public const TI_MINUS_DI = 'MINUS_DI';
    public const TI_PLUS_DI = 'PLUS_DI';
    public const TI_MINUS_DM = 'MINUS_DM';
    public const TI_PLUS_DM = 'PLUS_DM';
    public const TI_PLUS_BBANDS = 'BBANDS';
    public const TI_PLUS_MIDPOINT = 'MIDPOINT';
    public const TI_PLUS_MIDPRICE = 'MIDPRICE';
    public const TI_PLUS_SAR = 'SAR';
    public const TI_PLUS_TRANGE = 'TRANGE';
    public const TI_PLUS_ATR = 'ATR';
    public const TI_PLUS_NATR = 'NATR';
    public const TI_PLUS_AD = 'AD';
    public const TI_PLUS_ADOSC = 'ADOSC';
    public const TI_PLUS_OBV = 'OBV';
    public const TI_PLUS_HT_TRENDLINE = 'HT_TRENDLINE';
    public const TI_PLUS_HT_SINE = 'HT_SINE';
    public const TI_PLUS_HT_TRENDMODE = 'HT_TRENDMODE';
    public const TI_PLUS_HT_DCPERIOD = 'HT_DCPERIOD';
    public const TI_PLUS_HT_DCPHASE = 'HT_DCPHASE';
    public const TI_PLUS_HT_PHASOR = 'HT_PHASOR';

    private static array $validFunctions = [
            self::TI_SMA,
            self::TI_EMA,
            self::TI_WMA,
            self::TI_DEMA,
            self::TI_TEMA,
            self::TI_TRIMA,
            self::TI_KAMA,
            self::TI_MAMA,
            self::TI_VWAP,
            self::TI_T3,
            self::TI_MACD,
            self::TI_MACDEXT,
            self::TI_STOCH,
            self::TI_STOCHF,
            self::TI_RSI,
            self::TI_STOCHRSI,
            self::TI_WILLR,
            self::TI_ADX,
            self::TI_ADXR,
            self::TI_APO,
            self::TI_PPO,
            self::TI_MOM,
            self::TI_BOP,
            self::TI_CCI,
            self::TI_CMO,
            self::TI_ROC,
            self::TI_ROCR,
            self::TI_AROON,
            self::TI_AROONOSC,
            self::TI_MFI,
            self::TI_TRIX,
            self::TI_ULTOSC,
            self::TI_DX,
            self::TI_MINUS_DI,
            self::TI_PLUS_DI,
            self::TI_MINUS_DM,
            self::TI_PLUS_DM,
            self::TI_PLUS_BBANDS,
            self::TI_PLUS_MIDPOINT,
            self::TI_PLUS_MIDPRICE,
            self::TI_PLUS_SAR,
            self::TI_PLUS_TRANGE,
            self::TI_PLUS_ATR,
            self::TI_PLUS_NATR,
            self::TI_PLUS_AD,
            self::TI_PLUS_ADOSC,
            self::TI_PLUS_OBV,
            self::TI_PLUS_HT_TRENDLINE,
            self::TI_PLUS_HT_SINE,
            self::TI_PLUS_HT_TRENDMODE,
            self::TI_PLUS_HT_DCPERIOD,
            self::TI_PLUS_HT_DCPHASE,
            self::TI_PLUS_HT_PHASOR,
    ];

    private static array $validIntervals = [
        self::INTERVAL_1_MIN,
        self::INTERVAL_5_MIN,
        self::INTERVAL_15_MIN,
        self::INTERVAL_30_MIN,
        self::INTERVAL_60_MIN
    ];

    private static array $validSeriesTypes = [
        self::SERIES_TYPE_CLOSE,
        self::SERIES_TYPE_HIGH,
        self::SERIES_TYPE_LOW,
        self::SERIES_TYPE_OPEN
    ];

    private string $function;
    private string $symbol;
    private string $interval;
    private int $time_period;
    private string $series_type;
    private string $datatype;

    public function __construct(
        string $function,
        string $symbol,
        string $interval,
        int $time_period,
        string $series_type,
        string $dataType = self::DATATYPE_JSON
    ) {
        if ($dataType !== self::DATATYPE_JSON && $dataType !== self::DATATYPE_CSV) {
            throw new InvalidArgumentException($dataType . ' is not valid, try: csv or json');
        }

        if (!in_array($function, self::$validFunctions, true)) {
            throw new InvalidArgumentException(
                $function . ' is not valid, check https://www.alphavantage.co/documentation/ for valid Technical Indicator functions'
            );
        }

        if (!in_array($interval, self::$validIntervals, true)) {
            throw new InvalidArgumentException(
                $interval . ' is not valid, valid ones are: 1min, 5min, 15min, 30min, 60min'
            );
        }

        if (!in_array($series_type, self::$validSeriesTypes, true)) {
            throw new InvalidArgumentException(
                $series_type . ' is not valid, valid ones are: close, open, low, high'
            );
        }

        $this->function = $function;
        $this->symbol = $symbol;
        $this->interval = $interval;
        $this->time_period = $time_period;
        $this->series_type = $series_type;
        $this->datatype = $dataType;
    }

    public function getQueryString(): string
    {
        return http_build_query($this);
    }
}
