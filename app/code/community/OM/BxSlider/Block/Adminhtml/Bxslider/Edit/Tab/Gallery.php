<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 18:01
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Adminhtml_Bxslider_Edit_Tab_Gallery extends Mage_Adminhtml_Block_Widget {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('bxslider/edit/tab/gallery.phtml');
    }

    protected function _prepareLayout() {
        $this->setChild('uploader',
            $this->getLayout()->createBlock('adminhtml/media_uploader')
        );

        $this->getUploader()->getConfig()
            ->setUrl(Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('*/*/upload'))
            ->setFileField('image')
            ->setFilters(array(
                'images' => array(
                    'label' => Mage::helper('adminhtml')->__('Images (.gif, .jpg, .png)'),
                    'files' => array('*.gif', '*.jpg','*.jpeg', '*.png')
                )
            ));

        Mage::dispatchEvent('bxslider_gallery_prepare_layout', array('block' => $this));

        return parent::_prepareLayout();
    }

    /**
     * Retrive uploader block
     *
     * @return Mage_Adminhtml_Block_Media_Uploader
     */
    public function getUploader() {
        return $this->getChild('uploader');
    }

    /**
     * Retrive uploader block html
     *
     * @return string
     */
    public function getUploaderHtml() {
        return $this->getChildHtml('uploader');
    }

    public function getJsObjectName() {
        return $this->getHtmlId() . 'JsObject';
    }

    public function getAddImagesButton() {
        return $this->getButtonHtml(
            Mage::helper('bxslider')->__('Add New Images'),
            $this->getJsObjectName() . '.showUploader()',
            'add',
            $this->getHtmlId() . '_add_images_button'
        );
    }

    public function getImagesJson() {
        $model = Mage::registry('bxslider_data');
        if(isset($model['content']) && !empty($model['content'])){
            $content = Mage::helper('core')->jsonDecode($model->getData('content'));
            $this->aasort($content,"position");
            $content = Mage::helper('core')->jsonEncode($content);
            return $content;
        }
        return '[]';
    }

    function aasort (&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[]=$array[$ii];
        }
        $array = $ret;
    }

    public function getImagesValuesJson() {
        $values = array();
        return Mage::helper('core')->jsonEncode($values);
    }



    public function getImageTypesJson() {
        return Mage::helper('core')->jsonEncode($this->getImageTypes());
    }

    protected function getStoreId() {
        return Mage::app()->getStore(true)->getId();
    }
}