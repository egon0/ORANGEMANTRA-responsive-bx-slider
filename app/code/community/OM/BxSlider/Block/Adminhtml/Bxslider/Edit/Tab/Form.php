<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 17:41
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Adminhtml_Bxslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $model = Mage::registry('bxslider_data');

        if($model->getStores())
        {
            $model->setStores(explode(',',$model->getStores()));
        }
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('bxslider_form', array('legend'=>Mage::helper('bxslider')->__('General Information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('bxslider')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('position', 'select', array(
            'label'     => Mage::helper('bxslider')->__('Position'),
            'name'      => 'position',
            'values'    => Mage::getSingleton('bxslider/config_source_position')->toOptionArray(),
            'value'     => $model->getPosition()
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('stores', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('cms')->__('Store View'),
                'title'     => Mage::helper('cms')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                'value'     => $model->getStores()
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }



        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('bxslider')->__('Is Active'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('bxslider')->__('Yes'),
                ),
                array(
                    'value'     => 2,
                    'label'     => Mage::helper('bxslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('advanced_settings', 'textarea', array(
            'label'     => Mage::helper('bxslider')->__('Advanced Settings'),
            'required'  => false,
            'name'      => 'advanced_settings',
            //'after_element_html'    =>  '<p>For more option check this <a href="http://bxslider.com/options">link</a></p>',
            'note'   	=> "example: {mode: 'horizontal',speed:'500',captions: false,dots: true}.
                        <p>For more option check this <a target='_blank' href=\"http://bxslider.com/options\">link</a>
                        .This setting will override the default setting which you have saved in configuration. To use the default configuration keep it blank.</p>"
        ));

        if (Mage::getSingleton('adminhtml/session')->getBxSliderData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBxSliderData());
            Mage::getSingleton('adminhtml/session')->setBxSliderData(null);
        } elseif ( Mage::registry('bxslider_data') ) {
            $form->setValues(Mage::registry('bxslider_data')->getData());
        }
        return parent::_prepareForm();
    }
}