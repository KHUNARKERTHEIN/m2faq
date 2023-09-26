<?php
/**
 * @author Ksolves Team
 * @copyright Copyright (c) 2020 Ksolves (https://www.ksolves.com)
 * @package Ksolves_FAQ
 */

namespace Ksolves\FAQ\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class ConfigData extends AbstractHelper
{
    const XML_PATH_FAQ = 'faq/';

     protected $_customerSession;

     public function __construct(
        \Magento\Framework\App\Helper\Context $context, 
        \Magento\Customer\Model\SessionFactory $customerSession) {
        $this->_customerSession = $customerSession->create();
        parent::__construct($context);
    }

     

      /**
     * @return Magento\Store\Model\ScopeInterface
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

      /**
     * @return string
     */
    
    public function getGeneralConfigData($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_FAQ .'general/'. $code, $storeId);
    }

      /**
     * @return string
     */

    public function getHelpfulnessConfigData($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_FAQ .'helpfulness_ratings/'. $code, $storeId);
    }

    /**
    * @return $ipaddress
    */
    public function getIp()
    {

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {

            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {

            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {

            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

     /**
    * @return customer
    */
    public function getCustomerData()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomer();
        }
    }
    
}
