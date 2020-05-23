<?php

namespace ThirdParts\AgoraBundle\Service\DTO;

use ThirdParts\AgoraBundle\Exception\AgoraDTOException;

trait AgoraDTOTrait
{
    public function getExtractItem(\stdClass $data, string $property)
    {
        if (!property_exists($data, $property)) {
            throw new AgoraDTOException('No se puede extraer la propiedad '.$property);
        }

        return $data->$property;
    }
}
