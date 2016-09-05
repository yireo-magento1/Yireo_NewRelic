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
 * Abstract block for RUM timing blocks
 */
abstract class Yireo_NewRelic_Block_Rum_Timing_Abstract extends Mage_Core_Block_Template
{
    /**
     * @return mixed
     */
    public abstract function getContentHtml();

    /**
     * @return Yireo_NewRelic_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('newrelic');
    }

    /**
     * @return bool
     */
    protected function _canShow()
    {
        $isEnabled = $this->_getHelper()->isEnabled();
        $isUseRUM = $this->_getHelper()->isUseRUM();

        return $isEnabled && $isUseRUM;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_canShow()) {
            return '';
        }

        return parent::_toHtml();
    }
}
