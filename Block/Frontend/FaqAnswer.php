<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Block\Frontend;

/**
* class FaqAnswer
*/
class FaqAnswer extends \Magento\Framework\View\Element\Template
{
    /**
    * \Ksolves\FAQ\Model\Post $Faq
    */
    protected $_Faq;
    protected $pageConfig;
    protected $meta_title;
    protected $meta_description;
    protected $_storeManager;
    protected $_helpfulness;
    protected $_helppost;
    protected $_configData;
    protected $_customerSession;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ksolves\FAQ\Model\PostFactory $Faq,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Ksolves\FAQ\Helper\ConfigData $configData,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Ksolves\FAQ\Model\HelpfulnessFactory $helpfulness,
        \Ksolves\FAQ\Model\Helpfulness $helppost,
        \Ksolves\FAQ\Helper\ConfigData $helperData,
        \Magento\Customer\Model\Session  $customerSession
    ) {
        $this->_Faq = $Faq;
        $this->_storeManager = $storeManager;
        $this->pageConfig = $pageConfig;
        $this->_configData = $configData;
        $this->_helpfulness = $helpfulness;
        $this->helperData = $helperData;
        $this->_helppost = $helppost;
        $this->_isScopePrivate = true;
        $this->_objectManager = $objectmanager;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

     /**
     * @return $this
     */
     
    protected function _prepareLayout()
    {
        $id = $this->getRequest()->getParam('faq_id');
        $record = $this->_Faq->create()->load($id);

        $this->pageConfig->getTitle()->set(__(strval($record['meta_title'])));
        $this->pageConfig->setDescription(__(strval($record['meta_description'])));
        return $this;
    }

    public function getFaqDetail()
    {
        $id = $this->getRequest()->getParam('faq_id');
        $record = $this->_Faq->create()->load($id);
        $ipVotingOnly = $this->_configData->getHelpfulnessConfigData('user_ip_only');
        
        if ($ipVotingOnly) {

            $user_info = $this->_configData->getIp();

        } else {

            if ($this->_customerSession->isLoggedIn()) {
                $user_info = strval($this->_customerSession->getCustomer()->getEmail());

            } else {
                $user_info = $this->_configData->getIp();
            }
        }


        if ($ipVotingOnly) {

            $votingRecord= $this->_helppost->getCollection()->addFieldToFilter('user_ip', $user_info)->addFieldToFilter('faq_id', $record['faq_id'])
            ->getData() ;

        } else {

            if (!$this->_customerSession->isLoggedIn()) {

                $votingRecord= $this->_helppost->getCollection()->addFieldToFilter('user_ip', $user_info)->addFieldToFilter('faq_id', $record['faq_id'])
                ->getData() ;

            } elseif ($this->_customerSession->isLoggedIn()) {

                $votingRecord= $this->_helppost->getCollection()->addFieldToFilter('user_email', $user_info)->addFieldToFilter('faq_id', $record['faq_id'])
                ->getData() ;

            }
        
        }

        $store = $this->_storeManager->getStore();
        $mediaPath = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $this->meta_title = $record['meta_title'];
        $this->meta_description = $record['meta_description'];
        $data =  array('record' => $record , 'media' => $mediaPath, 'votingrecord' => $votingRecord);

        return $data;
    }

    /**
    * Module Status
    * @return Int
    */

    public function getModuleStatus()
    {
        return $this->helperData->getGeneralConfigData('enable');
    }

    /**
    *  Text
    * @return String
    */

    public function allowTopLink()
    {
        return $this->helperData->getGeneralConfigData('allow_toplink');
    }

    /**
    *  Text
    * @return String
    */

    public function allowFooterLink()
    {
        return $this->helperData->getGeneralConfigData('allow_footerlink');
    }

    /**
     * redirect contoller to home 
     * @return void
     */
    public function getRedirect()
    {
        $store = $this->_storeManager->getStore();
        $redirect = $this->_objectManager->get('\Magento\Framework\App\Response\Http');
        $redirect->setRedirect($store->getBaseUrl());
        return ;
    }
}
