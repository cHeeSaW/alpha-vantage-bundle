<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Service;

use cHeeSaW\AlphaVantageBundle\Endpoints\Endpoint;
use Exception;

interface AlphaVantage
{
    /**
     * @throws Exception
     */
    public function get(Endpoint $endpoint): string;
}
