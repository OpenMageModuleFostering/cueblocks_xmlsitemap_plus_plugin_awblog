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

    /**
     * Init resource model (catalog/category)
     *
     */
    protected function _construct()
    {
        $this->_init('blog/blog', 'post_id');
    }

    /**
     * Retrieve cms page collection array
     *
     * @param unknown_type $storeId
     * @return array
     */
    public function getCollection($storeId)
    {
        $pages = array();

        $select = $this->_getWriteAdapter()->select()
            ->from(array('main_table' => $this->getMainTable()), array($this->getIdFieldName(), 'identifier AS url', 'DATE(update_time) as updated_at'))
            ->join(
                array('store_table' => $this->getTable('blog/store')),
                'main_table.post_id=store_table.post_id',
                array()
            )
            ->where('main_table.status=?', AW_Blog_Model_Status::STATUS_ENABLED)
            ->where('store_table.store_id IN(?)', array(0, $storeId));
        $query = $this->_getWriteAdapter()->query($select);

//        die($select);

        return $query;
    }

}