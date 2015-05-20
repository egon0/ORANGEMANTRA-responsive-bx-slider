<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 16-01-2015 16:25
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Adminhtml_Bxslider_Edit_Tab_Page extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $_model = Mage::registry('bxslider_data');
        if($_model->getPageId())
        {
            $_model->setPageId(explode(',',$_model->getPageId()));
        }
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('bxslider_form', array('legend'=>Mage::helper('bxslider')->__('Banner Pages')));
        $fieldset->addField('pages', 'multiselect', array(
            'label'     => Mage::helper('bxslider')->__('Visible In'),
            'name'      => 'pages[]',
            'values'    => Mage::getSingleton('bxslider/config_source_page')->toOptionArray(),
            'value'     => $_model->getPageId()
        ));

        return parent::_prepareForm();
    }
}