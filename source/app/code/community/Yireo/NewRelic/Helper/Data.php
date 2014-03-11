<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo (http://www.yireo.com/)
 * @copyright   Copyright (C) 2014 Yireo (http://www.yireo.com/)
 * @license     Simplified BSD License
 */

class Yireo_NewRelic_Helper_Data extends Mage_Core_Helper_Abstract 
{
    /*
     * Check whether this module can be used
     *
     * @access public
     * @param null
     * @return bool
     */
    public function isEnabled() 
    {
        if (!extension_loaded('newrelic')) {
            return false;
        }

        return $this->getConfigFlag('enabled');
    }

    /*
     * Return the appname
     *
     * @access public
     * @param null
     * @return string
     */
    public function getAppName() 
    {
        return $this->getConfigValue('appname');
    }

    /*
     * Return the New Relic license
     *
     * @access public
     * @param null
     * @return string
     */
    public function getLicense() 
    {
        return $this->getConfigValue('license');
    }

    /*
     * Return whether to use the xmit flag
     *
     * @access public
     * @param null
     * @return bool
     */
    public function isUseXmit() 
    {
        return $this->getConfigFlag('xmit');
    }

    /*
     * Return whether to track the controller
     *
     * @access public
     * @param null
     * @return bool
     */
    public function isTrackController() 
    {
        return $this->getConfigFlag('track_controller');
    }

    /*
     * Return whether to use Real User Monitoring
     *
     * @access public
     * @param null
     * @return bool
     */
    public function isUseRUM() 
    {
        return $this->getConfigFlag('real_user_monitoring');
    }

    /*
     * Return a value from the configuration
     *
     * @access public
     * @param null
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

    /*
     * Return a boolean flag for the configuration
     *
     * @access public
     * @param null
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
