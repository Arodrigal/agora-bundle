<?php

namespace ThirdParts\AgoraBundle\Tests;

use ThirdParts\AgoraBundle\ThirdPartsAgoraBundle;
use Symfony\Component\HttpKernel\Kernel;

class AgoraTestingKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new ThirdPartsAgoraBundle()
        ];
    }

    public function registerContainerConfiguration(\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        // TODO: Implement registerContainerConfiguration() method.
        //return $loader->load(__DIR__.'/Resouces/config/_'.$this->getEnvironment().'.yml');
        return $loader->load(__DIR__.'/../Resources/config/eight_points_guzzle.yaml');
    }
}
