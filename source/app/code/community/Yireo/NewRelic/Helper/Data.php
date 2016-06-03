<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo (https://www.yireo.com/)
 * @copyright   Copyright 2016 Yireo (https://www.yireo.com/)
 * @license     Simplified BSD License
 */

class Yireo_NewRelic_Helper_Data extends Mage_Core_Helper_Abstract 
{
    /**
     * Check whether this module can be used
     *
     * @return bool
     */
    public function isEnabled() 
    {
        if ((bool)Mage::getStoreConfig('advanced/modules_disable_output/Yireo_NewRelic')) {
            return false;
        }

        if (!extension_loaded('newrelic')) {
            return false;
        }

        return $this->getConfigFlag('enabled');
    }

    /**
     * Return the appname
     *
     * @return string
     */
    public function getAppName() 
    {
        return $this->getConfigValue('appname');
    }

    /**
     * Return the New Relic license
     *
     * @return string
     */
    public function getLicense() 
    {
        return $this->getConfigValue('license');
    }

    /**
     * Return whether to use the xmit flag
     *
     * @return bool
     */
    public function isUseXmit() 
    {
        return $this->getConfigFlag('xmit');
    }

    /**
     * Return whether to track the controller
     *
     * @return bool
     */
    public function isTrackController() 
    {
        return $this->getConfigFlag('track_controller');
    }

    /**
     * Return whether to use Real User Monitoring
     *
     * @return bool
     */
    public function isUseRUM() 
    {
        return $this->getConfigFlag('real_user_monitoring');
    }

    /**
     * Return a value from the configuration
     *
     * @return bool
     */
    public function getConfigValue($key = null, $default_value = null) 
    {
        $value = Mage::getStoreConfig('newrelic/settings/' . $key);
        if (empty($value)) {
            $value = $default_value;
        }
        return $value;
    }

    /**
     * Return a boolean flag for the configuration
     *
     * @return bool
     */
    public function getConfigFlag($key = null, $defaultValue = false) 
    {
        $result = Mage::getStoreConfigFlag('newrelic/settings/' . $key);
        if (empty($result)) {
            $result = $defaultValue;
        }

        return $result;
    }

}
