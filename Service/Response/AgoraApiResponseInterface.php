<?php

namespace ThirdParts\AgoraBundle\Service\Response;

interface AgoraApiResponseInterface
{
    /** return array */
    public function response();

    /** return array */
    public function getData();

    /** bool */
    public function isResponseOk();
}
