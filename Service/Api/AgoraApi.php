<?php

namespace ThirdParts\AgoraBundle\Service\Api;

use Guzzle\Client;
use ThirdParts\AgoraBundle\Exception\AgoraApiException;
use ThirdParts\AgoraBundle\Service\DTO\ItemsAgoraDTO;
use ThirdParts\AgoraBundle\Service\Response\AgoraApiResponse;
use ThirdParts\AgoraBundle\Service\Response\AgoraApiResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SharepointApi.
 */
class AgoraApi extends AgoraApiAbstract implements AgoraApiInterface
{
    /**
     * @param string $sharepointFolderId
     * @return AgoraApiResponseInterface
     */
    public function listFiles(string $sharepointFolderId): AgoraApiResponseInterface
    {
        try {
            $this->logger->info('Llamada API Agora para obtener el listado de los documentos de una carpeta: ');
            //$url = $this->getGraphUrl(self::URL_FOLDER, $sharepointFolderId);
            //$res = $this->client->request(Request::METHOD_GET, $url, $this->getOptionsHeaders());
            //return new AgoraApiResponse(\Symfony\Component\HttpFoundation\Response::HTTP_OK, 'ok', $this->extractData($res->getBody()));
            return new AgoraApiResponse(\Symfony\Component\HttpFoundation\Response::HTTP_OK, 'ok');
        } catch (\Exception $e) {
            $errorMessage = 'Error API Sharepoint para obtener el listado de los documentos de una carpeta, message: '.$e->getMessage();
            $this->logger->error($errorMessage);
            throw new AgoraApiException($errorMessage);
        }
    }
}
