<?php

namespace ThirdParts\AgoraBundle\Exception;

use Exception;

class AgoraDTOException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct();
        $this->message = 'Error al extraer el parámetro de respuesta de la api sharepoint: '.$message;
    }
}
