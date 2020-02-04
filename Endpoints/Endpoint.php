<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Endpoints;

interface Endpoint
{
    public const DATATYPE_JSON = 'json';
    public const DATATYPE_CSV = 'csv';

    public const OUTPUTSIZE_COMPACT = 'compact';
    public const OUTPUTSIZE_FULL = 'full';

    public const INTERVAL_1_MIN = '1min';
    public const INTERVAL_5_MIN = '5min';
    public const INTERVAL_15_MIN = '15min';
    public const INTERVAL_30_MIN = '30min';
    public const INTERVAL_60_MIN = '60min';
    public const INTERVAL_DAILY = 'daily';
    public const INTERVAL_WEEKLY = 'weekly';
    public const INTERVAL_MONTHLY = 'monthly';

    public const TIME_PERIOD_60 = 60;
    public const TIME_PERIOD_200 = 200;

    public const SERIES_TYPE_CLOSE = 'close';
    public const SERIES_TYPE_OPEN = 'open';
    public const SERIES_TYPE_HIGH = 'high';
    public const SERIES_TYPE_LOW = 'low';

    public function getQueryString(): string;
}
