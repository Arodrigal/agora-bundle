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
 * Class SharepointApiAbstract.
 */
class AgoraApiAbstract
{
    protected const TOKEN_EXPIRED_SECONDS = 3000;
    protected const URL_LIST_FILES = 'https://graph.microsoft.com/v1.0/drives/'.self::CONST_CONTAINER_ID.'/root/children';
    protected const URL_FOLDER = 'https://graph.microsoft.com/v1.0/drives/'.self::CONST_CONTAINER_ID.'/items/'.self::CONST_FOLDER_ID.'/children';
    protected const URL_DOCUMENT = 'https://graph.microsoft.com/v1.0/drives/'.self::CONST_CONTAINER_ID.'/items/'.self::CONST_DOCUMENT_ID.'/content';
    protected const URL_DOCUMENT_THUMBNAIL = 'https://graph.microsoft.com/v1.0/drives/'.self::CONST_CONTAINER_ID.'/items/'.self::CONST_DOCUMENT_ID.'/thumbnails';
    protected const URL_ITEM = 'https://graph.microsoft.com/v1.0/drives/'.self::CONST_CONTAINER_ID.'/items/'.self::CONST_DOCUMENT_ID;
    protected const URL_UPLOAD_ITEM = 'https://graph.microsoft.com/v1.0/drives/'.self::CONST_CONTAINER_ID.'/items/'.self::CONST_FOLDER_ID.'/'.self::CONST_FILE_NAME.'/content';

    protected const TOKEN_SCOPE = 'https://graph.microsoft.com/.default';
    protected const URL_TOKEN = 'https://login.microsoftonline.com/laliga.es/oauth2/v2.0/token';

    protected const CONST_CONTAINER_ID = '[CONTAINER_ID]';
    protected const CONST_FOLDER_ID = '[FOLDER_ID]';
    protected const CONST_DOCUMENT_ID = '[DOCUMENT_ID]';
    protected const CONST_FILE_NAME = '[FILE_NAME]';
    protected const ARRAY_CONST = [
        self::CONST_FOLDER_ID,
        self::CONST_DOCUMENT_ID,
        self::CONST_FILE_NAME
    ];

    protected LoggerInterface $logger;
    protected Client $client;
    protected string $azureClientId;
    protected string $azureClientSecret;
    protected string $sharepointContainerId;
    protected ?string $token = null;
    protected float $executeStartTime;

    /**
     * SharepointApi constructor.
     */
    public function __construct(
        Client $client,
        LoggerInterface $logger,
        string $azureClientId,
        string $azureClientSecret,
        string $sharepointContainerId
    ) {
        $this->executeStartTime = microtime(true);
        $this->logger = $logger;
        $this->client = $client;
        $this->azureClientId = $azureClientId;
        $this->azureClientSecret = $azureClientSecret;
        $this->token = $this->getToken();
        if (!$sharepointContainerId) {
            throw new AgoraApiException('Debe de introducir el id del contenedor de sharepoint como parametro del proyecto SHAREPOINT_CONTAINER_ID');
        }
        $this->sharepointContainerId = $sharepointContainerId;
    }

    protected function listFolders(?string $idParentFolder = null): ItemsAgoraDTO
    {
        try {
            $this->logger->info('Llamada API Agora para obtener el listado de los documentos de una carpeta');
            if (is_null($idParentFolder)) {
                $url = $this->getGraphUrl(self::URL_LIST_FILES);
            } else {
                $url = $this->getGraphUrl(self::URL_FOLDER, $idParentFolder);
            }
            $res = $this->client->request(Request::METHOD_GET, $url, $this->getOptionsHeaders());
            return new ItemsAgoraDTO($this->extractData($res->getBody()));
        } catch (\Exception $e) {
            $errorMessage = 'Error API Agora para obtener el listado de los documentos de una carpeta, message: '.$e->getMessage();
            $this->logger->error($errorMessage);
            throw new AgoraApiException($errorMessage);
        }
    }

    protected function normalizePath(string $path): array
    {
        $explode = explode(DIRECTORY_SEPARATOR, $path);
        $result = [];
        foreach ($explode as $item) {
            if (trim($item)) {
                $result[] = $item;
            }
        }

        return $result;
    }

    protected function callCreateFolder(string $name, ?string $idParentFolder = null)
    {
        try {
            $this->logger->info('Llamada API Agora para crear carpeta : '.$name);
            $options = $this->getOptionsHeaders();
            $options['body'] = '{
              "name": "'.$name.'",
              "folder": { },
              "@microsoft.graph.conflictBehavior": "rename"
            }';
            $url = $this->getGraphUrl(self::URL_FOLDER, $idParentFolder);
            $res = $this->client->request(Request::METHOD_POST, $url, $options);
            $bodyRes = $this->extractData($res->getBody());
            return $bodyRes->id;
        } catch (ClientException $e) {
            $errorMessage = 'Error API Agora para para crear carpeta '.$name.', message: '.$e->getMessage();
            $this->logger->error($errorMessage);
            throw new AgoraApiException($errorMessage);
        }
    }

    protected function getToken()
    {
        if (!is_null($this->token) && !$this->tokenExpired()) {
            return $this->token;
        }

        try {
            $options['form_params'] =
                [
                    'client_id' => $this->azureClientId,
                    'grant_type' => 'client_credentials',
                    'scope' => self::TOKEN_SCOPE,
                    'client_secret' => $this->azureClientSecret,
                ]
            ;

            $this->logger->info('Llamada API Agora para obtener el token: ');
            $res = $this->client->request(Request::METHOD_POST, self::URL_TOKEN, $options);
            $resultado = json_decode($res->getBody());
            if (!property_exists($resultado, 'access_token')) {
                throw new AgoraApiException('No se puede acceder al token en la llamada a la api de agora');
            }

            return $resultado->access_token;
        } catch (ClientException $e) {
            /* @var Response $res */
            $this->logger->error('Error API Agora al obtener el token: message: '.$e->getMessage());
            throw new AgoraApiException('Error API Agora al obtener el token: message: '.$e->getMessage());
        }
    }

    protected function tokenExpired(): bool
    {
        $time_end = microtime(true);
        $execution_time = ($time_end - $this->executeStartTime) / 60;
        if (round($execution_time) > self::TOKEN_EXPIRED_SECONDS) {
            return true;
        }
        return false;
    }

    protected function getOptionsHeaders()
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->getToken(),
            ],
        ];
    }

    protected function getGraphUrl(string $url, ... $parameters): string
    {
        $url = str_replace(self::CONST_CONTAINER_ID, $this->sharepointContainerId, $url);
        foreach ($parameters as $parameter) {
            foreach (self::ARRAY_CONST as $const) {
                $break = strstr($url, $const);
                $url = str_replace($const, $parameter, $url);
                if ($break) {
                    break;
                }
            }
        }
        return $url;
    }

    /**
     * @return mixed
     */
    protected function extractData(StreamInterface $stream)
    {
        return json_decode($stream->getContents());
    }
}
