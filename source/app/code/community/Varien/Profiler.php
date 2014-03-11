<?php
/**
 * NewRelic plugin for Magento
 *
 * @package     Yireo_NewRelic
 * @author      Yireo
 * @copyright   Copyright (c) 2013 Yireo (http://www.yireo.com/)
 * @license     Open Software License
 */

if(class_exists('Yireo_NewRelic_Model_Profiler')) {
    class Varien_Profiler extends Yireo_NewRelic_Model_Profiler 
    {
        /*
         * this is just to have the extended profiler class
         * everything else is in the yireo profiler
         */
    }
}
