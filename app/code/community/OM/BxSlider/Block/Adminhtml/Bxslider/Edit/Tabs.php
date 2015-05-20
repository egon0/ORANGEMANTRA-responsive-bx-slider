<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 17:37
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Adminhtml_Bxslider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('bxslider_tabs');
        $this->setName('bxslider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bxslider')->__('Slider Information'));
    }

    protected function _beforeToHtml() {

        $this->addTab('general_section', array(
            'label'     => Mage::helper('bxslider')->__('General Information'),
            'title'     => Mage::helper('bxslider')->__('General Information'),
            'content'   => $this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tab_form')->toHtml(),
        ));

        $content = Mage::getSingleton('core/layout')->createBlock('bxslider/adminhtml_bxslider_edit_tab_gallery');
        $content->setId($this->getHtmlId() . '_content')->setElement($this);

        $this->addTab('gallery_section', array(
            'label'     => Mage::helper('bxslider')->__('Slider Images'),
            'title'     => Mage::helper('bxslider')->__('Slider Images'),
            'content'   => $content->toHtml(),
        ));


        $this->addTab('page_section', array(
            'label'     => Mage::helper('bxslider')->__('Show on Pages'),
            'title'     => Mage::helper('bxslider')->__('Show on Pages'),
            'content'   => $this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tab_page')->toHtml(),
        ));

        $this->addTab('category_section', array(
            'label'     => Mage::helper('bxslider')->__('Show on Categories'),
            'title'     => Mage::helper('bxslider')->__('Show on Categories'),
            'content'   => $this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tab_category')->toHtml(),
        ));

        if($id = $this->getRequest()->getParam('id')) {
            $this->addTab('additional_section', array(
                'label'     => Mage::helper('bxslider')->__('External Code'),
                'title'     => Mage::helper('bxslider')->__('External Code'),
                'content'   => $this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tab_additional')->toHtml(),
            ));
        }

        return parent::_beforeToHtml();
    }
}