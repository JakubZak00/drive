<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(2, $crawler->filter('a'));
        $client->clickLink('View');
        $this->assertResponseIsSuccessful();
    }
}
