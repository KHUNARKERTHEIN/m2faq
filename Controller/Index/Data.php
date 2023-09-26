<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Controller\Index;

/**
* class Data
*/
class Data extends \Magento\Framework\App\Action\Action
{
   /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $_pageFactory;

  /**
   * Core registry
   *
   * @var \Magento\Framework\Registry
   */
    protected $_CoreRegistry;
  /**
   * Core registry
   *
   * @var \Magento\Framework\StoreManager
   */
    protected $_storeManager;
    protected $_Faq;
    protected $_helpfulness;
    protected $_helppost;
    protected $_configData;
    protected $_customerSession;
    protected $_Faqgroup;

    /**
    * Initialize Group Controller
    *
    * @param \Magento\Backend\App\Action\Context $context
    * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
    * @param \Ksolves\FAQ\Model\Post $Faq
    * @param \Magento\Store\Model\StoreManagerInterface $storeManager
    * @param \Magento\Framework\Registry $coreRegistry
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Ksolves\FAQ\Model\PostFactory $Faq,
        \Ksolves\FAQ\Model\FaqFactory $Faqgroup,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $coreRegistry,
        \Ksolves\FAQ\Helper\ConfigData $configData,
        \Ksolves\FAQ\Model\HelpfulnessFactory $helpfulness,
        \Ksolves\FAQ\Model\Helpfulness $helppost,
        \Magento\Customer\Model\SessionFactory $customerSession
    ) {
        $this->_Faq = $Faq;
        $this->_pageFactory = $pageFactory;
        $this->_CoreRegistry = $coreRegistry;
        $this->_storeManager = $storeManager;
        $this->_configData = $configData;
        $this->_helpfulness = $helpfulness;
        $this->_helppost = $helppost;
        $this->_Faqgroup = $Faqgroup;
        $this->_customerSession = $customerSession->create();
        return parent::__construct($context);
    }

    

    /**
    * @return $resultFactory
    */
    public function execute()
    {
        $data = $this->getRequest()->getPost();
        $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $ipVotingOnly = $this->_configData->getHelpfulnessConfigData('user_ip_only');

        if ($ipVotingOnly) {

            $user_info = $this->_configData->getIp();

        } else {


            if ($this->_customerSession->isLoggedIn()) {
                $user_info = strval($this->_customerSession->getCustomer()->getEmail());
            } else {
                $user_info = strval($this->_configData->getIp());
            }
        }
        

        if ($data['displayAfter'] == 'Yes') {

            $faqRecord = $this->_Faq->create()->load($data['id']);
            $helpfulness_rate = $faqRecord->getData('helpfulness_rate');
            $html =  '(' . $helpfulness_rate  . '% of other  found it helpful )';
            $response->setData(['success' => true, 'data' => $html]);

        } elseif ($data['helpful'] == 'yes') {
            try {

                $faqRecord = $this->_Faq->create()->load($data['id']);
                $helpfulVotes = $faqRecord->getData('helpful_votes') + 1;
                $totalVotes = $faqRecord->getData('total_votes') + 1;
                $helpPercent = ($helpfulVotes * 100) / $totalVotes;
                $updatedData =  array('helpful_votes' => $helpfulVotes, 'total_votes' => $totalVotes, 'helpfulness_rate' => $helpPercent);

                $helpRecord = $this->_helpfulness->create();
                if ($ipVotingOnly) {
                    $helpRecord->setData('user_ip', $user_info);
                } else {
                    if (!$this->_customerSession->isLoggedIn()) {
                        $helpRecord->setData('user_ip', $user_info);
                    } else {
                        $helpRecord->setData('user_email', $user_info);
                    }
                }

                $helpRecord->setData('faq_id', $data['id']);
                $helpRecord->setData('helpfulness', 1);
                $helpRecord->save();

                $faqRecord->addData($updatedData);
                $faqRecord->setId($data['id'])->save();
            } catch (\Exception $ee) {
                $response->setData(['success' => 'exception', 'data' =>$ee->getMessage()]);
            }

            $response->setData(['success' => true, 'data' =>$updatedData]);

        } elseif ($data['helpful'] == 'No') {

            $faqRecord = $this->_Faq->create()->load($data['id']);
            $helpfulVotes = $faqRecord->getData('helpful_votes');
            $totalVotes = $faqRecord->getData('total_votes') + 1;
            $helpPercent = ($helpfulVotes * 100) / $totalVotes;
            $updatedData =  array('helpful_votes' => $helpfulVotes, 'total_votes' => $totalVotes, 'helpfulness_rate' => $helpPercent);
            try {

                $helpRecord = $this->_helpfulness->create();

                if ($ipVotingOnly) {
                    $helpRecord->setData('user_ip', $user_info);
                } else {
                    if (!$this->_customerSession->isLoggedIn()) {

                        $helpRecord->setData('user_ip', $user_info);
                    } else {

                        $helpRecord->setData('user_email', $user_info);
                    }
                }

                $helpRecord->setData('faq_id', $data['id']);
                $helpRecord->setData('helpfulness', 0);
                $helpRecord->save();

                $faqRecord->addData($updatedData);
                $faqRecord->setId($data['id'])->save();
            } catch (\Exception $ee) {
                $response->setData(['success' => false,
                   'data' =>$ee->getMessage()]);
            }
            $response->setData(['success' => true, 'data' =>$faqRecord->getData()]);

            
        } else {

            try {

                $groupid= strval($data['id']);
                
                $grpData = $this->_Faqgroup->create()->load($groupid);
                $record= $this->_Faq->create()->getCollection()->addFieldToFilter('faqgroup_id', array("like"=> '%'.$groupid.'%'))
                ->addFieldToFilter('status', '1')->setOrder('sort_order', 'ASC')->getData();

                $store = $this->_storeManager->getStore();
                $mediaPath = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $html = '';
                if (count($record) > 0) {
                    foreach ($record as $records) {
 
                        $actionLink = $this->_storeManager->getStore()->getBaseUrl()."ksfaq/". $grpData['group_code'] ."/" . $records['url_key'];
                        $ksId = strval('acc' . $records["faq_id"]);
                        $html .='<form method="post" action=';
                        $html .=  $actionLink;
                        $html .= '><button  class="accordion"  >'.$records["faq"].'</button></form>';

                    }
                } else {
                    $html .=' <h1> No, FAQ Found</h1>';
                }

            } catch (\Exception $exception) {

            }

            $response->setData(['success' => true, 'data' => $html]);


        }


        return $response;
    }
}
