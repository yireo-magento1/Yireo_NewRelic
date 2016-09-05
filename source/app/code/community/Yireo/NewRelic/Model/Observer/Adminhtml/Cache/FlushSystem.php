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
 * Class Yireo_NewRelic_Model_Observer_Adminhtml_Cache_FlushSystem
 */
class Yireo_NewRelic_Model_Observer_Adminhtml_Cache_FlushSystem extends Yireo_NewRelic_Model_Observer_Generic
{
    /**
     * Listen to the event adminhtml_cache_flush_system
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @event adminhtml_cache_flush_system
     */
    public function execute(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        newrelic_custom_metric('Magento/Event/adminhtmlCacheFlushSystem', (float)1.0);

        return $this;
    }
}
