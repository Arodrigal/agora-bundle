<?php

namespace ThirdParts\AgoraBundle\Tests;

use ThirdParts\AgoraBundle\Service\Api\AgoraApi;
use PHPUnit\Framework\TestCase;

class AgoraTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new AgoraTestingKernel('test', true);
        
        $kernel->boot();
        $container = $kernel->getContainer();

        /** @var AgoraApi $service */
        //$service = $container->get('thirdparts.agora.api');
        $service = $container->get('test.thirdparts.agora.api');

        $this->assertInstanceOf(AgoraApi::class, $service);
    }
}
