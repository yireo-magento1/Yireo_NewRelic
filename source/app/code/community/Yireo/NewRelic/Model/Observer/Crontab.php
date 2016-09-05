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
 * Class Yireo_NewRelic_Model_Observer_Crontab
 */
class Yireo_NewRelic_Model_Observer_Crontab
{
    /**
     * Listen to the cron event always
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     */
    public function execute(Varien_Event_Observer $observer)
    {
        if (function_exists('newrelic_background_job')) {
            newrelic_background_job(true);
        }

        return $this;
    }
}
