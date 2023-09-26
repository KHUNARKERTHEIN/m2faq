<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Model\Faq;

use Ksolves\FAQ\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Ksolves\FAQ\Model\ResourceModel\Post\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    protected $storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $allnewsCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        StoreManagerInterface $storeManager,
        CollectionFactory $allnewsCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $allnewsCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
        $this->storeManager = $storeManager;
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $path = $this->storeManager->getStore()->getBaseUrl(
        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            foreach ($items as $news) {
               $this->loadedData[$news->getId()] = $news->getData();

            if ($news->getImage()) {
               $image['image'][0]['url'] = $path.$news->getImage();
               $image['image'][0]['name'] = $news->getImage();
               $fullData = $this->loadedData;
               $this->loadedData[$news->getId()] = array_merge($fullData[$news->getId()], $image);
            }

        }

        $data = $this->dataPersistor->get('ksolves_faq_post');
        if (!empty($data)) {
            $news = $this->collection->getNewEmptyItem();
            $news->setData($data);
            $this->loadedData[$news->getId()] = $news->getData();
            $this->dataPersistor->clear('ksolves_faq_post');
        }
        return $this->loadedData;
    }
}
