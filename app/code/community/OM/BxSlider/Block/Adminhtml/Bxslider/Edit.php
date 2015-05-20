<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 17:32
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */
class OM_BxSlider_Block_Adminhtml_Bxslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {

        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bxslider';
        $this->_controller = 'adminhtml_bxslider';

        $this->_updateButton('save', 'label', Mage::helper('bxslider')->__('Save Slider'));
        $this->_updateButton('delete', 'label', Mage::helper('bxslider')->__('Delete Slider'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('bxslider_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'bxslider_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'bxslider_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText() {
        if( Mage::registry('bxslider_data') && Mage::registry('bxslider_data')->getId() ) {
            return Mage::helper('bxslider')->__("Edit Slider '%s'", $this->htmlEscape(Mage::registry('bxslider_data')->getTitle()));
        } else {
            return Mage::helper('bxslider')->__('Add Slider');
        }
    }
}