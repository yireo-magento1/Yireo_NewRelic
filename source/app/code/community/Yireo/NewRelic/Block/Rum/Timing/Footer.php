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
