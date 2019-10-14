<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{

    protected static function getKernelClass()
    {
        return \App\Kernel::class;
    }

    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSinglepage()
    {
        $client = static::createClient();
        $value = rand(1,10);
        $url = "/tricks/details/$value/page";
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}

