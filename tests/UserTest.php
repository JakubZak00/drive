<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/exam');
        $this->assertCount(2, $crawler->filter('h4'));
        $client->clickLink('View');
        $this->assertResponseIsSuccessful();
    }
}
