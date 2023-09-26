<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

 namespace Ksolves\FAQ\Controller\Index;

/*
* class FaqSearch
*/
class FaqSearch extends \Magento\Framework\App\Action\Action
{
    /*
	* \Ksolves\FAQ\Model\ResourceModel\Post\CollectionFactory
	*/
    protected $_Faq;

    protected $_Faqgroup;

    /**
    * \Ksolves\FAQ\Model\Helpfulness
    */
    protected $_helppost;

    /**
    * \Magento\Customer\Model\SessionFactory
    */
    protected $_customerSession;

    /**
    * \Ksolves\FAQ\Helper\ConfigData
    */
    protected $_ConfigData;

    /**
    * \Magento\Store\Model\StoreManagerInterface
    */
    protected $_storeManager;

    /**
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Ksolves\FAQ\Model\ResourceModel\Post\CollectionFactory $Faq
    * @param \Ksolves\FAQ\Model\Helpfulness $helppost
    * @param \Ksolves\FAQ\Helper\ConfigData $ConfigData
    * @param \Magento\Store\Model\StoreManagerInterface $storeManager
    * @param \Magento\Customer\Model\SessionFactory $customerSession
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Ksolves\FAQ\Model\ResourceModel\Post\CollectionFactory $Faq,
        \Ksolves\FAQ\Model\ResourceModel\Faq\CollectionFactory $Faqgroup,
        \Ksolves\FAQ\Model\Helpfulness $helppost,
        \Ksolves\FAQ\Helper\ConfigData $ConfigData,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\SessionFactory $customerSession
    ) {
        $this->_helppost = $helppost;
        $this->_customerSession = $customerSession->create();
        $this->_Faq = $Faq;
        $this->_Faqgroup = $Faqgroup;
        $this->_storeManager = $storeManager;
        $this->_ConfigData = $ConfigData;
        return parent::__construct($context);

    }

    /**
    * @return array of FAQs
    */
    public function execute()
    {
        $store = $this->_storeManager->getStore();
        $mediaPath = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $data = $this->getRequest()->getPost();
        try {
            if (strip_tags($data['keyword']) == $data['keyword']) {
                $keyword = $data['keyword'];

                $faqgroupCollection = $this->_Faqgroup->create()->addFieldToFilter('status', true);
                foreach ($faqgroupCollection as $data) {
                   $faqGroupIds[] = $data['faqgroup_id'];
                }

                $record= $this->_Faq->create()->addFieldToFilter(
                    ['faq', 'content'],
                    [
                        ["like"=> '%'.$keyword.'%'],
                        ["like"=> '%'.$keyword.'%']
                    ]
                )->addFieldToFilter('faqgroup_id',array('in' => array($faqGroupIds)))->addFieldToFilter('status', true)->getData();
            } else {
                    $record = array();
                    count($record);
            }
        } catch (\Exception $e) {
            $record=[];
        }

        $html = '';
        if (count($record) > 0) {
            foreach ($record as $records) {
                 
                $ksId = strval('acc' . $records["faq_id"]);
                $actionLink = $this->_storeManager->getStore()->getBaseUrl()."ksfaq/searchresult/" . $records['url_key'];
                $ksId = strval('acc' . $records["faq_id"]);
                $html .='<form method="Post" action=';
                $html .=  $actionLink;
                $html .= '><input  name="faq_id" value= '. $records["faq_id"] . ' type="hidden" id='. $records["faq_id"] . '></input><button  class="accordion"  >'.$records["faq"].'</button></form>';
            }
        } else {
                    $html .=' <h1> No, FAQ Found</h1>';
        }

        $response->setData(['success' => true, 'data' => $html]);
        return $response;

    }
}
