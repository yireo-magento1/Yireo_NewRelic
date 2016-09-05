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
 * Class Yireo_NewRelic_Model_Observer_Generic
 */
class Yireo_NewRelic_Model_Observer_Generic
{
    /**
     * Method to setup the app-name
     *
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
     * @param Mage_Core_Controller_Front_Action $action
     *
     * @return $this
     */
    protected function _trackControllerAction($action)
    {
        if (!$this->_getHelper()->isTrackController()) {
            return $this;
        }

        if (function_exists('newrelic_name_transaction')) {
            newrelic_name_transaction($this->_getHelper()->getSystemPath());
        }

        return $this;
    }

    /**
     * Method to check wether this module can be used or not
     *
     * @return bool
     */
    protected function _isEnabled()
    {
        return $this->_getHelper()->isEnabled();
    }

    /**
     * Method to return the helper
     *
     * @return Yireo_NewRelic_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('newrelic');
    }
}
