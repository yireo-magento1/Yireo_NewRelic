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
 * Timing head block adding the rum track html
 */
class Yireo_NewRelic_Block_Rum_Timing_Footer extends Yireo_NewRelic_Block_Rum_Timing_Abstract 
{
    public function getContentHtml() 
    {
        return (function_exists('newrelic_get_browser_timing_footer'))
            ? newrelic_get_browser_timing_footer(true)
            : '';
    }
}
