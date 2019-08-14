<?php

/**
 * Description of Observer
 * @package   CueBlocks_SitemapEnhancedPlus
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */

/**
 * SitemapEnhancedPlus module observer
 *
 * @category   Mage
 * @package    Mage_Sitemap
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class CueBlocks_SitemapPluginAwBlog_Model_Observer extends Varien_Object
{
    public function processSource($event)
    {
        $sitemap  = $event->getSitemap();
        //
        Mage::getModel('sitemapPluginAwBlog/processor_blog_blog')->process($sitemap);
    }
}
