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
 * Class Yireo_NewRelic_Model_Observer
 */
class Yireo_NewRelic_Model_Observer
{
    /**
     * Listen to the event adminhtml_cache_flush_all
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Cache_FlushAll::execute()
     */
    public function adminhtmlCacheFlushAll(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event adminhtml_cache_flush_system
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Cache_FlushSystem::execute()
     */
    public function adminhtmlCacheFlushSystem(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event adminhtml_cache_refresh_type
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Cache_RefreshType::execute()
     */
    public function adminhtmlCacheRefreshType(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_reindexProcess
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Process_ReindexProcess::execute()
     */
    public function controllerActionPostdispatchAdminhtmlProcessReindexProcess(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event controller_action_postdispatch_adminhtml_process_massReindex
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Adminhtml_Process_ReindexProcess::execute()
     */
    public function controllerActionPostdispatchAdminhtmlProcessMassReindex(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event controller_action_predispatch
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Initialise::execute()
     */
    public function controllerActionPredispatch(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Post dispatch observer for user tracking
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_AddRequestData::execute()
     */
    public function controllerActionPostdispatch(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event model_save_after
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Model_SaveAfter::execute()
     */
    public function modelSaveAfter(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the event model_delete_after
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Model_DeleteAfter::execute()
     */
    public function modelDeleteAfter(Varien_Event_Observer $observer)
    {
        return $this;
    }

    /**
     * Listen to the cron event always
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     * @deprecated Use Yireo_NewRelic_Model_Observer_Crontab::execute()
     */
    public function crontab($observer)
    {
        return $this;
    }
}
