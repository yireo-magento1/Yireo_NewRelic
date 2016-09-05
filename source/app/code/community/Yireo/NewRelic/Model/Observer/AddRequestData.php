<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo (https://www.yireo.com/)
 * @copyright   Copyright 2016 Yireo (https://www.yireo.com/)
 * @license     Simplified BSD License
 */

/**
 * Class Yireo_NewRelic_Model_Observer_AddRequestData
 */
class Yireo_NewRelic_Model_Observer_AddRequestData extends Yireo_NewRelic_Model_Observer_Generic
{
    /**
     * @var Zend_Controller_Request_Http
     */
    protected $request;

    /**
     * @var Mage_Core_Model_Store
     */
    protected $store;

    /**
     * @var Mage_Customer_Model_Session
     */
    protected $customerSession;

    /**
     * @var array
     */
    protected $userAttributes = array('email', 'name', 'product');

    /**
     * Yireo_NewRelic_Model_Observer_AddRequestData constructor.
     */
    public function __construct()
    {
        $this->request = Mage::app()->getRequest();
        $this->store = Mage::app()->getStore();
        $this->customerSession = Mage::getSingleton('customer/session');
    }

    /**
     * Listen to the event controller_action_predispatch
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @event controller_action_predispatch
     */
    public function execute(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        $this->logGenericData();
        $this->logCustomerData();
        $this->logProductData();
        $this->logCategoryData();
        $this->logRUM();

        return $this;
    }

    /**
     * Log generic data
     */
    protected function logGenericData()
    {
        newrelic_add_custom_parameter('magento_url', $this->request->getOriginalPathInfo());
        newrelic_add_custom_parameter('magento_module', $this->request->getModuleName());
        newrelic_add_custom_parameter('magento_controller', $this->request->getControllerName());
        newrelic_add_custom_parameter('magento_request', $this->request->getRequestUri());
        newrelic_add_custom_parameter('magento_store_id', $this->store->getId());
    }


    /**
     * Log customer data
     */
    protected function logCustomerData()
    {
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = $this->customerSession->getCustomer();
        $customerName = trim($customer->getName());
        $customerEmail = trim($customer->getEmail());

        // Correct empty values
        if (empty($customerName)) {
            $customerName = 'guest';
        }

        if (empty($customerEmail)) {
            $customerEmail = 'guest';
        }

        // Set customer-data
        newrelic_add_custom_parameter('magento_customer_email', $customerEmail);
        newrelic_add_custom_parameter('magento_customer_name', $customerName);

        $this->userAttributes['email'] = $customerEmail;
        $this->userAttributes['name'] = $customerName;
    }

    /**
     * Log product data
     */
    protected function logProductData()
    {
        // Get and set product-data
        $product = Mage::registry('current_product');
        $productSku = null;

        if (!empty($product)) {
            $productSku = $product->getSku();
            newrelic_add_custom_parameter('magento_product_name', $product->getName());
            newrelic_add_custom_parameter('magento_product_sku', $product->getSku());
            newrelic_add_custom_parameter('magento_product_id', $product->getId());
        }

        $this->userAttributes['product'] = $productSku;
    }

    /**
     * Log category data
     */
    protected function logCategoryData()
    {
        $category = Mage::registry('current_category');
        if ($category) {
            newrelic_add_custom_parameter('magento_category_name', $category->getName());
            newrelic_add_custom_parameter('magento_category_id', $category->getId());
        }
    }

    /**
     * Log RUM
     */
    protected function logRUM()
    {
        $email = $this->userAttributes['email'];
        $name = $this->userAttributes['email'];
        $product = $this->userAttributes['product'];

        // Set user attributes
        if ($this->_getHelper()->isUseRUM()) {
            newrelic_set_user_attributes($email, $name, $product);
        }
    }
}
