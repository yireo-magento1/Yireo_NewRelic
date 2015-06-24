<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo (http://www.yireo.com/)
 * @copyright   Copyright 2015 Yireo (http://www.yireo.com/)
 * @license     Simplified BSD License
 */

class Yireo_NewRelic_Model_Observer 
{
    /**
     * Listen to the event adminhtml_cache_flush_all
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function adminhtmlCacheFlushAll($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }
        
        newrelic_custom_metric('Magento/Event/adminhtmlCacheFlushAll', (float)1.0);
        return $this;
    }

    /**
     * Listen to the event adminhtml_cache_flush_system
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function adminhtmlCacheFlushSystem($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }
        
        newrelic_custom_metric('Magento/Event/adminhtmlCacheFlushSystem', (float)1.0);
        return $this;
    }

    /**
     * Listen to the event adminhtml_cache_refresh_type
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function adminhtmlCacheRefreshType($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }
        
        $event = $observer->getEvent();
        $refreshType = $event->getType();
        newrelic_custom_metric('Magento/Event/adminhtmlCacheRefreshType:'.$refreshType, (float)1.0);
        return $this;
    }

    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_reindexProcess
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function controllerActionPostdispatchAdminhtmlProcessReindexProcess($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }
        
        $processIds = (array)Mage::app()->getRequest()->getParam('process');
        if (!empty($processIds) && is_array($processIds)) {
            try {
                $indexer = Mage::getSingleton('index/indexer');
                foreach ($processIds as $processId) {
                    $process = $indexer->getProcessById($processId);
                    $indexerCode = $process->getIndexerCode();
                    newrelic_custom_metric('Magento/Event/reindex:'.$indexerCode, (float)1.0);
                }

            } catch (Exception $e) {
                Mage::logException($e);
                return $this;
            }
        }

        return $this;
    }

    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_massReindex
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function controllerActionPostdispatchAdminhtmlProcessMassReindex($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        $processIds = (array)Mage::app()->getRequest()->getParam('process');
        if (!empty($processIds) && is_array($processIds)) {
            try {
                $indexer = Mage::getSingleton('index/indexer');
                foreach ($processIds as $processId) {
                    $process = $indexer->getProcessById($processId);
                    $indexerCode = $process->getIndexerCode();
                    newrelic_custom_metric('Magento/Event/reindex:'.$indexerCode, (float)1.0);
                }

            } catch (Exception $e) {
                Mage::logException($e);
                return $this;
            }
        }

        return $this;
    }

    /**
     * Listen to the event controller_action_predispatch
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function controllerActionPredispatch($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        $this->_setupAppName();
        $this->_trackControllerAction($observer->getEvent()->getControllerAction());

        // Ignore Apdex for Magento Admin Panel pages
        if (Mage::app()->getStore()->isAdmin()) {
            if(function_exists('newrelic_ignore_apdex')) {
                newrelic_ignore_apdex();
            }
        }

        // Common settings
        if(function_exists('newrelic_capture_params')) {
            newrelic_capture_params(true);
        }

        return $this;
    }

    /**
     * Method to setup the app-name
     *
     * @access public
     * @param null
     * @return $this
     */
    protected function _setupAppName() 
    {
        $helper = $this->_getHelper();
        $appname = trim($helper->getAppName());
        $license = trim($helper->getLicense());
        $xmit = $helper->isUseXmit();

        if (!empty($appname) && function_exists('newrelic_set_appname')) {
            newrelic_set_appname($appname, $license, $xmit);
        }

        return $this;
    }

    /**
     * Method to track the controller-action
     *
     * @access public
     * @param Mage_Core_Controller_Front_Action $action
     * @return $this
     */
    protected function _trackControllerAction($action) 
    {
        if (!$this->_getHelper()->isTrackController()) {
            return $this;
        }

        $actionName = $action->getFullActionName('/');
        if (function_exists('newrelic_name_transaction')) {
            newrelic_name_transaction($actionName);
        }

        return $this;
    }

    /**
     * Post dispatch observer for user tracking
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function controllerActionPostdispatch($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        // Set generic data
        newrelic_add_custom_parameter('magento_controller', Mage::getModel('core/url')->getRequest()->getControllerModule());
        newrelic_add_custom_parameter('magento_request', Mage::getModel('core/url')->getRequest()->getRequestUri());
        newrelic_add_custom_parameter('magento_store_id', Mage::app()->getStore()->getId());

        // Get customer-data
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $customerName = trim($customer->getName());
        $customerEmail = trim($customer->getEmail());

        // Correct empty values
        if (empty($customerName)) $customerName = 'guest';
        if (empty($customerEmail)) $customerEmail = 'guest';

        // Set customer-data
        newrelic_add_custom_parameter('magento_customer_email', $customerEmail);
        newrelic_add_custom_parameter('magento_customer_name', $customerName);

        // Get and set product-data
        $product = Mage::registry('current_product');
        if (!empty($product)) {
            $productSku = $product->getSku();
            newrelic_add_custom_parameter('magento_product_name', $product->getName());
            newrelic_add_custom_parameter('magento_product_sku', $product->getSku());
            newrelic_add_custom_parameter('magento_product_id', $product->getId());
        } else {
            $productSku = null;
        }

        $category = Mage::registry('current_category');
        if ($category) {
            newrelic_add_custom_parameter('magento_category_name', $category->getName());
            newrelic_add_custom_parameter('magento_category_id', $category->getId());
        }

        // Set user attributes
        newrelic_set_user_attributes($customerEmail, $customerName, $productSku);

        return $this;
    }

    /**
     * Listen to the event model_save_after
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function modelSaveAfter($observer) 
    {
        if ($this->_isEnabled()) {
            return $this;
        }

        if (!function_exists('newrelic_custom_metric')) {
            return $this;
        }
        $object = $observer->getEvent()->getObject();
        newrelic_custom_metric('Magento/' . get_class($object) . '_Save', (float)1.0);

        return $this;
    }

    /**
     * Listen to the event model_delete_after
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function modelDeleteAfter($observer) 
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        if (!function_exists('newrelic_custom_metric')) {
            return $this;
        }

        $object = $observer->getEvent()->getObject();
        newrelic_custom_metric('Magento/' . get_class($object) . '_Delete', (float)1.0);

        return $this;
    }

    /**
     * Method to check wether this module can be used or not
     *
     * @access public
     * @param null
     * @return bool
     */
    protected function _isEnabled() 
    {
        return $this->_getHelper()->isEnabled();
    }

    /**
     * Method to return the helper
     *
     * @access public
     * @param null
     * @return Yireo_NewRelic_Helper_Data
     */
    protected function _getHelper() 
    {
        return Mage::helper('newrelic');
    }

    /**
     * Listen to the cron event always
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function crontab($observer) 
    {
        if(function_exists('newrelic_background_job')) {
            newrelic_background_job(true);
        }
    }
}
