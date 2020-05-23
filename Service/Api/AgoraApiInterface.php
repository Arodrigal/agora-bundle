<?php

namespace ThirdParts\AgoraBundle\Service\Api;

use ThirdParts\AgoraBundle\Service\Response\AgoraApiResponseInterface;

interface AgoraApiInterface
{
    public function listFiles(string $sharepointFolderId): AgoraApiResponseInterface;

}
