<?php

declare(strict_types=1);

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SwipeControllerTest extends WebTestCase
{
	public function testRender(): void
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/swipe');
		$this->assertResponseRedirects('swipe/select');
	}

	public function testRenderWithParameters(): void
	{
		$client = static::createClient();
		$client->request('GET', 'swipe/1');
		$this->assertSelectorTextContains('div', 'Jarin');
		$this->assertSelectorTextContains('div', 'U Sněžky 11');
	}

	public function testRenderPremium(): void
	{
		$client = static::createClient();
		$crawler = $client->request('GET', 'swipe/1/1');
		$this->assertSame('PREMIUM KLIENT', $crawler->filter('span.premium-badge')->text());
	}
}
