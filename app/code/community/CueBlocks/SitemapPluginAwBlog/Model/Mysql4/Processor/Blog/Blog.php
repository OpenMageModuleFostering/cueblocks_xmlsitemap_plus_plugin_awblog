<?php
/**
 * Description of
 * @package   CueBlocks_SitemapPluginAwBlog
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 * @support   <magento at cueblocks.com>
 */


class CueBlocks_SitemapPluginAwBlog_Model_Mysql4_Processor_Blog_Blog extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Collection Zend Db select
     *
     * @var Zend_Db_Select
     */
    protected $_select;

    protected $_config = null;

    /**
     * Init resource model (catalog/category)
     *
     */
    protected function _construct()
    {
        $this->_init('blog/blog', 'post_id');
    }

    public function init($config)
    {
        $this->_config = $config;
        return $this;
    }

    protected function _setSql()
    {
        $storeId = $this->_config->getStoreId();
        $pages = array();

        $this->_select = $this->_getWriteAdapter()->select()
            ->from(array('main_table' => $this->getMainTable()), array($this->getIdFieldName(), 'identifier AS url', 'DATE(update_time) as updated_at'))
            ->join(
                array('store_table' => $this->getTable('blog/store')),
                'main_table.post_id=store_table.post_id',
                array()
            )
            ->where('main_table.status=?', AW_Blog_Model_Status::STATUS_ENABLED)
            ->where('store_table.store_id IN(?)', array(0, $storeId));
    }

    /**
     * Retrieve cms page collection array
     *
     * @param unknown_type $storeId
     * @return array
     */
    public function getCollection()
    {
        $this->_setSql(true);
        return $this->_getWriteAdapter()->query($this->_select);
    }

    /**
     * @return Count SQL for pagination
     * @throws Zend_Db_Select_Exception
     */
    public function getCount()
    {
        // populate select
        $this->_setSql(true);

        $countSelect = clone $this->_select;
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);

        $countSelect->columns('COUNT(*)');

        $count = $this->_getWriteAdapter()->fetchOne($countSelect);
        return $count;
    }

}