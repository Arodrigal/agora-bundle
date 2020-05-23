<?php

namespace ThirdParts\AgoraBundle\Service\DTO;

class ItemsAgoraDTO
{
    use AgoraDTOTrait;

    protected $items = [];

    public function __construct(?\stdClass $data = null)
    {
        /** @var array $dataItems */
        $dataItems = $this->getExtractItem($data, 'value');
        foreach ($dataItems as $item) {
            $this->items[] = new ItemAgoraDTO($item);
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function itemExist(string $itemName)
    {
        /** @var ItemAgoraDTO $item */
        foreach ($this->items as $item) {
            if ($item->getName() === $itemName) {
                return true;
            }
        }

        return false;
    }

    public function getIdParentFolderByName(string $itemName)
    {
        /** @var ItemAgoraDTO $item */
        foreach ($this->items as $item) {
            if ($item->getName() === $itemName) {
                return $item->getId();
            }
        }

        return false;
    }
}
