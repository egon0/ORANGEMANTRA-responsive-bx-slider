<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 16-01-2015 16:27
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Model_Config_Source_Page {

    public function toOptionArray() {
        $_collection = Mage::getSingleton('cms/page')->getCollection()->addFieldToFilter('is_active', 1);
        $_result = array();
        $_result[] =array(
            'value' =>'',
            'label' =>'',
        );
        foreach ($_collection as $item) {
            $data = array(
                'value' => $item->getData('page_id'),
                'label' => $item->getData('title'));
            $_result[] = $data;
        }
        return $_result;
    }
}