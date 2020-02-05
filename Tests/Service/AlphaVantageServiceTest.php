<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Tests\Service;

use cHeeSaW\AlphaVantageBundle\Service\AlphaVantageService;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class AlphaVantageServiceTest extends TestCase
{
    /** @var ClientInterface|ObjectProphecy */
    private $client;

    /** @var string */
    private $alphaVantageApiUrl;

    /** @var string */
    private $alphaVantageApiKey;

    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->client = $this->prophesize(ClientInterface::class);
        $this->alphaVantageApiUrl = '';
        $this->alphaVantageApiKey = '';

        $this->subject = new AlphaVantageService(
            $this->client->reveal(),
            $this->alphaVantageApiUrl,
            $this->alphaVantageApiKey
        );
    }

    public function testGet(): void
    {
        self::assertTrue(true);
    }


}
