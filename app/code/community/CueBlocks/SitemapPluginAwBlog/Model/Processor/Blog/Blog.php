<?php
/**
 * Description of
 * @package   CueBlocks_SitemapPluginAwBlog
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 * @support   <magento at cueblocks.com>
 */


class CueBlocks_SitemapPluginAwBlog_Model_Processor_Blog_Blog extends CueBlocks_SitemapEnhancedPlus_Model_Processor_Abstract
{
    protected $_configKey = 'blog';
    protected $_sourceModel = 'sitemapPluginAwBlog/processor_blog_blog';
    protected $_fileName = '_blog';
    protected $_counterLabel = 'AW Blog';

    protected function _getUrl($row)
    {
        $url = '';
        $route = Mage::getStoreConfig('blog/blog/route');
        if ($route == "") {
            $route = "blog";
        }

        $url = $route . '/' . $row['url'];
        return $url;
    }
}