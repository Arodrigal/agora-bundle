<?php

namespace ThirdParts\AgoraBundle\Exception;

use Exception;

class AgoraApiException extends Exception implements AgoraApiExceptionInterface
{
    public function __construct(string $message = '')
    {
        parent::__construct();
        $this->message = 'Error al conectar a la api: '.$message;
    }
}
