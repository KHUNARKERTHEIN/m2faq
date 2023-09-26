<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\ObjectManagerInterface 
     */
    private $_objectManager;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder           = $urlBuilder;
        $this->_objectManager = $objectmanager;
        $this->imageHelper = $this->_objectManager->get(\Magento\Catalog\Helper\Image::class);
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    $item[$fieldName . '_src'] = $path.$item['image'];
                    $item[$fieldName . '_alt'] = 'FAQ Image';
                    $item[$fieldName . '_orig_src'] = $path.$item['image'];
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'ksolves_faq/post/edit',
                    ['faq_id' => $item['faq_id']]
                    );
                }else{
                    $item[$fieldName . '_src'] =   $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                    $item[$fieldName . '_alt'] = 'Place Holder';
                    $item[$fieldName . '_orig_src'] =   $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'ksolves_faq/post/edit',
                    ['faq_id' => $item['faq_id']]
                    );
                }
            }
        }

        return $dataSource;
    }
}
