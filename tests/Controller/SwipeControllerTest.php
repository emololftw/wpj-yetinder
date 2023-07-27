<?php

declare(strict_types=1);

namespace Controller;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class SwipeControllerTest extends WebTestCase
{
	/**
	 * @dataProvider provideControllers
	 */
	public function testControllers(string $request, callable $asserts): void
	{
		$client = static::createClient();
		$crawler = $client->request('GET', $request);
		$asserts($crawler);
	}

	public function provideControllers(): Generator
	{
		yield [
			'request' => 'swipe',
			'asserts' => function (Crawler $crawler) {
				$this->assertResponseRedirects('swipe/select');
			},
		];

		yield [
			'request' => 'swipe/1',
			'asserts' => function (Crawler $crawler) {
				$this->assertResponseIsSuccessful();
				$this->assertSelectorTextContains('div', 'Jarin');
				$this->assertSelectorTextContains('div', 'U Sněžky 11');
			},
		];

		yield [
			'request' => 'swipe/1/1',
			'asserts' => function (Crawler $crawler) {
				$this->assertResponseIsSuccessful();
				$this->assertSame('PREMIUM KLIENT', $crawler->filter('span.premium-badge')->text());
			},
		];

		yield [
			'request' => 'swipe/nothing',
			'asserts' => function (Crawler $crawler) {
				$this->assertResponseIsSuccessful();
				$this->assertSelectorTextContains('div', ':(');
			},
		];
	}
}
