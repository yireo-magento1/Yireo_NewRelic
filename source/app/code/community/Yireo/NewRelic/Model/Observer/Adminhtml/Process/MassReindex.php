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
 * Class Yireo_NewRelic_Model_Observer_Adminhtml_Process_MassReindex
 */
class Yireo_NewRelic_Model_Observer_Adminhtml_Process_MassReindex extends Yireo_NewRelic_Model_Observer_Generic
{
    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_massReindex
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @event controller_action_postdispatch_adminhtml_process_massReindex
     */
    public function execute(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled()) {
            return $this;
        }

        $processIds = (array)Mage::app()->getRequest()->getParam('process');
        if (!empty($processIds) && is_array($processIds)) {
            try {
                $indexer = Mage::getSingleton('index/indexer');
                foreach ($processIds as $processId) {
                    $process = $indexer->getProcessById($processId);
                    $indexerCode = $process->getIndexerCode();
                    newrelic_custom_metric('Magento/Event/reindex:' . $indexerCode, (float)1.0);
                }

            } catch (Exception $e) {
                Mage::logException($e);
                return $this;
            }
        }

        return $this;
    }
}
