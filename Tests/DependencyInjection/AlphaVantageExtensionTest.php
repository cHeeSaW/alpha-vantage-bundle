<?php

namespace cHeeSaW\AlphaVantageBundle\Tests\DependencyInjection;

use cHeeSaW\AlphaVantageBundle\DependencyInjection\AlphaVantageExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlphaVantageExtensionTest extends TestCase
{
    /**
     * @var AlphaVantageExtension
     */
    private AlphaVantageExtension $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new AlphaVantageExtension();
    }

    public function testLoad(): void
    {
        $containerBuilder = new ContainerBuilder();

        $this->subject->load([], $containerBuilder);

        self::assertSame($containerBuilder->getParameterBag()->get('alpha_vantage.api.url'), 'https://www.alphavantage.co/query?');
    }
}
