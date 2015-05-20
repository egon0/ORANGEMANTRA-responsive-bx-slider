<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 11:56
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Adminhtml_Bxslider extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_bxslider';
        $this->_blockGroup = 'bxslider';
        $this->_headerText = Mage::helper('bxslider')->__('Slider Manager');
        $this->_addButtonLabel = Mage::helper('bxslider')->__('Add New Slider');
        parent::__construct();
    }
}