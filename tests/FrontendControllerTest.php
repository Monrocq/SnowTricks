<?php

namespace App\Tests;

use App\Controller\FrontendController;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{
    /** @test */
    //Fonctionnel comme les autres élèves
    public function testGetAllTricks()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /** @test */
    //Unitaire
    public function testGetAllTricks2()
    {
        $test = new FrontendController;
        $test2 = new TrickRepository;
    }
}