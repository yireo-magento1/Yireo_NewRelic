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
 * Class Yireo_NewRelic_Model_Observer_Model_SaveAfter
 */
class Yireo_NewRelic_Model_Observer_Model_SaveAfter extends Yireo_NewRelic_Model_Observer_Generic
{
    /**
     * Listen to the event model_save_after
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @event model_save_after
     */
    public function execute(Varien_Event_Observer $observer)
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
}
