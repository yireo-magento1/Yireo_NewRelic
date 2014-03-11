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
 * Timing head block adding the rum init html
 */
class Yireo_NewRelic_Block_Rum_Timing_Header extends Yireo_NewRelic_Block_Rum_Timing_Abstract 
{
    public function getContentHtml() 
    {
        return (function_exists('newrelic_get_browser_timing_header'))
            ? newrelic_get_browser_timing_header(true)
            : '';
    }
}
