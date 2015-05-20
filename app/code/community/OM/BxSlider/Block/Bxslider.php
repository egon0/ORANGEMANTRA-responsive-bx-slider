<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 19-01-2015 14:04
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Bxslider extends Mage_Core_Block_Template {

    public function getCollection() {

        $enabled = Mage::getStoreConfig('bxslider/bxslider_group/active');
        if($enabled) {
            $storeId = Mage::app()->getStore()->getId();
            $collection = Mage::getModel('bxslider/bxslider')
                            ->getCollection()
                            ->addFieldToFilter('status', array('eq' => 1));

            if (!Mage::app()->isSingleStoreMode()) {
                $collection->addStoreFilter($storeId);
            }

            $sliderId = $this->getData('slider_id');
            if($sliderId) {
                $collection->addFieldToFilter('bxslider_id', array('eq' => $sliderId));
            } else {
                if(Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms') {
                    $pageId = Mage::getBlockSingleton('cms/page')->getPage()->getPageId();
                    $collection->addPageFilter($pageId);
                    $collection->addPositionFilter($this->getData('position'));
                }

                if (Mage::registry('current_category')) {
                    $categoryId = Mage::registry('current_category')->getId();
                    $collection->addCategoryFilter($categoryId);
                    $collection->addPositionFilter($this->getData('position'));
                }
            }
            //echo $collection->getSelect()->__toString();die;
            return $collection;
        } else {
            return null;
        }
    }

    public function getSortedImages($content){
        $images = json_decode($content,true);
        if(isset($images) && !empty($images) && count($images)>0){
            $temp = array();
            foreach($images as $key=>$image){
                if($image['disabled']){
                    unset($images[$key]);
                    continue;
                }
                $temp[$key] = $image['position'];
            }
            array_multisort($temp, SORT_ASC, $images);
        }
        return $images;
    }
}