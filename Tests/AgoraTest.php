<?php

namespace ThirdParts\AgoraBundle\Tests;

use ThirdParts\AgoraBundle\Service\Api\AgoraApi;
use PHPUnit\Framework\TestCase;

class AgoraTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new AgoraTestingKernel('test', true);
        //$kernel = new BlobStorageTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        /** @var AgoraApi $blob */
        $blob = $container->get('thirdparts.agora.api');

        $this->assertInstanceOf(AgoraApi::class, $blob);
    }
}
