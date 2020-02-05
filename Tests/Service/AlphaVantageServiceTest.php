<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Tests\Service;

use cHeeSaW\AlphaVantageBundle\Endpoints\Cryptocurrency;
use cHeeSaW\AlphaVantageBundle\Service\AlphaVantageService;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class AlphaVantageServiceTest extends TestCase
{
    /** @var ClientInterface|ObjectProphecy */
    private $client;

    /** @var string */
    private $alphaVantageApiUrl;

    /** @var string */
    private $alphaVantageApiKey;

    protected $subject;

    public function setUp(): void
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

    public function testGetSuccess(): void
    {
        $contents = 'contents';
        /** @var ResponseInterface $responseInterface */
        $responseInterface = $this->prophesize(ResponseInterface::class);
        $responseInterface->getStatusCode()->willReturn(200);

        /** @var StreamInterface $streamInterface */
        $streamInterface = $this->prophesize(StreamInterface::class);
        $responseInterface->getBody()->willReturn($streamInterface);

        $streamInterface->getContents()->willReturn($contents);
        $this->client->request('GET', Argument::type(Uri::class))->willReturn($responseInterface);

        $endpoint = new Cryptocurrency(Cryptocurrency::CRYPTO_CURRENCY_DAILY);
        $response = $this->subject->get($endpoint);

        self::assertSame($contents, $response);
    }

    public function testGetWrongStatusCode(): void
    {
        /** @var ResponseInterface $responseInterface */
        $responseInterface = $this->prophesize(ResponseInterface::class);
        $statusCode = 404;
        $responseInterface->getStatusCode()->willReturn($statusCode);

        $this->client->request('GET', Argument::type(Uri::class))->willReturn($responseInterface);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid statuscode returned: ' . $statusCode);

        $endpoint = new Cryptocurrency(Cryptocurrency::CRYPTO_CURRENCY_DAILY);
        $this->subject->get($endpoint);
    }

    public function testGetGuzzleException(): void
    {
        $this->client->request('GET', Argument::type(Uri::class))->willThrow(TransferException::class);

        $this->expectException(Exception::class);

        $endpoint = new Cryptocurrency(Cryptocurrency::CRYPTO_CURRENCY_DAILY);
        $this->subject->get($endpoint);
    }
}
