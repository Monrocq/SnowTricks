<?php

namespace App\Tests;

use App\Repository\TrickRepository;
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
        $value = 3;
        $url = "/tricks/details/$value/page";
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}

