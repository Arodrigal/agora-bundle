<?php

namespace ThirdParts\AgoraBundle\Service\DTO;

class ItemAgoraDTO
{
    use AgoraDTOTrait;

    protected $id;
    protected $name;
    protected $webUrl;

    public function __construct(\stdClass $data)
    {
        $this->id = $this->getExtractItem($data, 'id');
        $this->name = $this->getExtractItem($data, 'name');
        $this->webUrl = $this->getExtractItem($data, 'webUrl');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }

    /**
     * @param mixed $webUrl
     */
    public function setWebUrl($webUrl): void
    {
        $this->webUrl = $webUrl;
    }
}
