<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */
namespace Ksolves\FAQ\Block\Frontend\Links;

/**
* class Link
*/
class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
    * @param \Magento\Store\Model\StoreManagerInterface $storeManager
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Ksolves\FAQ\Helper\ConfigData $helperData
    */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Template\Context $context,
        \Ksolves\FAQ\Helper\ConfigData $helperData,
        array $data = []
    ) {
            $this->_storeManager = $storeManager;
            $this->helperData = $helperData;
            parent::__construct($context, $data);
    }

    /**
    *  return url of link
    * @param \Ksolves\FAQ\Helper\ConfigData $helperData
    * @return String
    */
    public function getHref()
    {
        $ksEnableLink = $this->helperData->getGeneralConfigData('allow_toplink');
        if ($ksEnableLink == 1) {
            $baseurl = $this->_storeManager->getStore()->getBaseUrl();
            $page_url =''.$baseurl.'ksfaq';
            return $this->getUrl($page_url);
        }
    }

    /**
    *  return label of link
    * @param \Ksolves\FAQ\Helper\ConfigData $helperData
    * @return  String
    */
    public function getLabel()
    {
        $ksEnableLink = $this->helperData->getGeneralConfigData('allow_toplink');
        if ($ksEnableLink == 1) {
            if ($this->helperData->getGeneralConfigData('display_text') != '') {
                return strval($this->helperData->getGeneralConfigData('display_text'));
                
            } else {
                    return'FAQ';
            }
        }
    }
}
