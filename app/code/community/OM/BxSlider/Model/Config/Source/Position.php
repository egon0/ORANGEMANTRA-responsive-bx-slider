<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 17:57
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Model_Config_Source_Position {

    const CONTENT_TOP       = 'CONTENT_TOP';
    const CONTENT_BOTTOM    = 'CONTENT_BOTTOM';
    const SIDEBAR_LEFT    = 'SIDEBAR_LEFT';
    const SIDEBAR_RIGHT    = 'SIDEBAR_RIGHT';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
        return array(
            array('value' => self::CONTENT_TOP, 'label'=>Mage::helper('adminhtml')->__('Content Top')),
            array('value' => self::CONTENT_BOTTOM, 'label'=>Mage::helper('adminhtml')->__('Content Bottom')),
            array('value' => self::SIDEBAR_LEFT, 'label'=>Mage::helper('adminhtml')->__('Left Sidebar')),
            array('value' => self::SIDEBAR_RIGHT, 'label'=>Mage::helper('adminhtml')->__('Right Sidebar')),
        );
    }
}