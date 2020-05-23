<?php

namespace ThirdParts\AgoraBundle\Exception;

interface AgoraApiExceptionInterface
{
    public function getMessage();

    public function getCode();
}
