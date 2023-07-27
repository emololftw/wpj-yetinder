<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
	public function testRender(): void
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/');
		$this->assertResponseIsSuccessful();
		$this->assertCount(10, $crawler->filter('tr.border-b'));
		$this->assertSelectorTextContains('div', 'Top 10 Yetyů');
	}
}
