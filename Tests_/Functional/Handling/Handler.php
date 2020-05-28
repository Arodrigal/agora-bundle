<?php
// Tests/Functional/Handling/Handler.php

namespace ThirdParts\AgoraBundle\Tests\Functional\Handling;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HandlerTest extends WebTestCase
{
    private $handler;

    protected function setUp()
    {
        require_once __DIR__.'/../../AppKernel.php';

        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        $this->handler = $container->get('thirdparts.agora.api');
    }

    public function testHandle()
    {
        $this->assert($this->handler->handle());
    }
}
