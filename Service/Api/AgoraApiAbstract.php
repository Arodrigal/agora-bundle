<?php

namespace ThirdParts\AgoraBundle\Service\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use ThirdParts\AgoraBundle\Exception\AgoraApiException;
use ThirdParts\AgoraBundle\Service\DTO\ItemsAgoraDTO;
use ThirdParts\AgoraBundle\Service\Response\AgoraApiResponse;
use ThirdParts\AgoraBundle\Service\Response\AgoraApiResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AgoraApiAbstract.
 */
class AgoraApiAbstract
{

    protected $logger = null;
    protected $client;
    protected $executeStartTime;
    //private $url;

    /**
     * SharepointApi constructor.
     */
    public function __construct(
        Client $client,
        LoggerInterface $logger
    ) {
        $this->executeStartTime = microtime(true);
        $this->logger = $logger;
        $this->client = $client;
        //$this->url = 
    }

    protected function listFolders(?string $idParentFolder = null): ItemsAgoraDTO
    {
        try {
            $this->logger->info('Llamada API Agora para obtener el listado de los documentos de una carpeta');
            //AgoraTest copy$res = $this->client->request(Request::METHOD_GET, $url, $this->getOptionsHeaders());
            //return new ItemsAgoraDTO($this->extractData($res->getBody()));
            return new ItemsAgoraDTO(null);
        } catch (\Exception $e) {
            $errorMessage = 'Error API Agora para obtener el listado de los documentos de una carpeta, message: '.$e->getMessage();
            $this->logger->error($errorMessage);
            throw new AgoraApiException($errorMessage);
        }
    }
}
