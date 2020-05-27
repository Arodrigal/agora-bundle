<?php

namespace ThirdParts\AgoraBundle\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use ThirdParts\AgoraBundle\Tests\Base\BaseCommandTester;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ThirdParts\AgoraBundle\Service\Api\AgoraApi;

class AgoraTest extends KernelTestCase
{
    
    public function testCall()
    {
        // $kernel = new SimpleKernel('SimpleKernel_test', true);
        //$kernel->boot();

        
        $service = self::bootKernel()::$container->get(AgoraApi::class);
        
        /** @var $service AgoraApi */
        $service = self::bootKernel()->getContainer()->get('test.thirdparts.agora.api');
        
        $service->listFiles('1');
        $this->assertTrue(true);

    }
}
