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
 * Class Yireo_NewRelic_Model_Observer_Adminhtml_Cache_RefreshType
 */
class Yireo_NewRelic_Model_Observer_Adminhtml_Cache_RefreshType extends Yireo_NewRelic_Model_Observer_Generic
{
    /**
     * Listen to the event adminhtml_cache_refresh_type
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @event adminhtml_cache_refresh_type
     */
    public function execute(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        $event = $observer->getEvent();
        $refreshType = $event->getType();
        newrelic_custom_metric('Magento/Event/adminhtmlCacheRefreshType:' . $refreshType, (float)1.0);

        return $this;
    }
}
