<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    protected static function getKernelClass()
    {
        return \App\Kernel::class;
    }

    public function testFakePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signin');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testRegisterPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}

