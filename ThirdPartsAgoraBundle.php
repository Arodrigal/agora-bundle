<?php

namespace ThirdParts\AgoraBundle;

use ThirdParts\AgoraBundle\DependencyInjection\ThirdPartsAgoraBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ThirdPartsAgoraBundle extends Bundle
{
    /**
     * Overridden to allow for the custom extension alias.
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ThirdPartsAgoraBundleExtension();
        }

        return $this->extension;
    }
}
