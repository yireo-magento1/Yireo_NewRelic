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
 * Class Yireo_NewRelic_Model_Observer_Initialise
 */
class Yireo_NewRelic_Model_Observer_Initialise extends Yireo_NewRelic_Model_Observer_Generic
{
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

        $this->_setupAppName();
        $this->_trackControllerAction($observer->getEvent()->getControllerAction());

        // Ignore Apdex for Magento Admin Panel pages
        if (Mage::app()->getStore()->isAdmin()) {
            if (function_exists('newrelic_ignore_apdex')) {
                newrelic_ignore_apdex();
            }
        }

        // Common settings
        if (function_exists('newrelic_capture_params')) {
            newrelic_capture_params(true);
        }

        return $this;
    }
}
