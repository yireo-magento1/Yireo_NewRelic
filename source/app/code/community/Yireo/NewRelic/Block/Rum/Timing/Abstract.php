<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo (http://www.yireo.com/)
 * @copyright   Copyright (C) 2014 Yireo (http://www.yireo.com/)
 * @license     Simplified BSD License
 */

/**
 * Abstract block for RUM timing blocks
 *
 */
abstract class Yireo_NewRelic_Block_Rum_Timing_Abstract extends Mage_Core_Block_Template {

    public abstract function getContentHtml();

    /**
     * @return Yireo_NewRelic_Helper_Data
     */
    protected function _getHelper() 
    {
        return Mage::helper('newrelic');
    }

    protected function _canShow() 
    {
        return $this->_getHelper()->isEnabled()
                && $this->_getHelper()->isUseRUM();
    }

    protected function _toHtml()    
    {
        if (!$this->_canShow()) {
            return '';
        }

        return parent::_toHtml();
    }
}
