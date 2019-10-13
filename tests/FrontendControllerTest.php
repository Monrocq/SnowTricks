<?php

namespace App\Tests;

use App\Controller\FrontendController;
//use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{

    public function testToto()
    {
        $client = static::createClient();

        $this->assertEquals(200, 200);
    }




}

