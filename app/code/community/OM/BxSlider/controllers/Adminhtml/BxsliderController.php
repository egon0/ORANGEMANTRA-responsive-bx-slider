<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 11:50
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Adminhtml_BxSliderController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('bxslider/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider Manager'), Mage::helper('adminhtml')->__('Slider Manager'));

        return $this;
    }

    public function indexAction() {

        $this->_title($this->__("Bx Slider"));
        $this->_title($this->__("Manager Slider"));

        $this->_initAction()
            ->renderLayout();
    }

    public function newAction() {

        $this->_title($this->__("Bx Slider"));
        $this->_title($this->__('New Slider'));

        $_model  = Mage::getModel('bxslider/bxslider');
        Mage::register('bxslider_data', $_model);
        Mage::register('current_banner', $_model);

        $this->_initAction();
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider Manager'), Mage::helper('adminhtml')->__('Slider Manager'), $this->getUrl('*'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Add Slider'), Mage::helper('adminhtml')->__('Add Slider'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit'))
            ->_addLeft($this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tabs'));

        $this->renderLayout();
    }

    public function uploadAction() {
        try {
            $uploader = new Varien_File_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->addValidateCallback('catalog_product_image', Mage::helper('catalog/image'), 'validateUploadFile');
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save($this->getBaseTmpMediaPath());

            Mage::dispatchEvent('bxslider_gallery_upload_image_after', array(
                'result' => $result,
                'action' => $this
            ));

            /**
             * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
             */
            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);
            $tempUrl = $this->_prepareFileForUrl($result['file']);
            if(substr($tempUrl, 0, 1) == '/') {
                $tempUrl = substr($tempUrl, 1);
            }
            $result['url']=$this->getBaseTmpMediaUrl() . '/' . $tempUrl;

            $result['file'] = $result['file'];
            $result['cookie'] = array(
                'name'     => session_name(),
                'value'    => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path'     => $this->_getSession()->getCookiePath(),
                'domain'   => $this->_getSession()->getCookieDomain()
            );
        } catch (Exception $e) {
            $result = array(
                'error' => $e->getMessage(),
                'errorCode' => $e->getCode());
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function editAction() {

        $this->_title($this->__("Bx Slider"));
        $this->_title($this->__('Edit Slider'));

        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('bxslider/bxslider')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('bxslider_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('bxslider/bxslider');

            $this->_addBreadcrumb(Mage::helper('adminhtml')
                    ->__('Banner Manager'), Mage::helper('adminhtml')->__('Banner Manager'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit'))
                ->_addLeft($this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bxslider')->__('Banner does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function categoriesJsonAction() {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('bxslider/bxslider')->load($id);
        Mage::register('bxslider_data', $model);

        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('bxslider/adminhtml_bxslider_edit_tab_category')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('filename');

                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders (file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);

                    $path = Mage::getBaseDir('media') . DS ;
                    $uploader->save($path, $_FILES['filename']['name'] );

                } catch (Exception $e) {

                }

                $data['filename'] = $_FILES['filename']['name'];
            }


            $model = Mage::getModel('bxslider/bxslider');
            if(isset($data['bxslider_tabs']['images']) && !empty($data['bxslider_tabs']['images'])){
                $images = Mage::helper('core')->jsonDecode($data['bxslider_tabs']['images'],true);
                $imageArray = array();
                foreach($images as $key=>$image){
                    if($image['removed']!=1){
                        $imageArray[] = $image;
                    }
                }
                $content = Mage::helper('core')->jsonEncode($imageArray);
                $data['content'] = $content;
                unset($data['bxslider_tabs']['images']);
            }

            if(isset($data['stores']) && !empty($data['stores'])){
                if(in_array('0',$data['stores'])){
                    $data['stores'] = array(0);
                }

                $data['stores'] = implode(',',$data['stores']);
            }
            if (isset($data['category_ids'])) {
                $data['category_ids'] = explode(',',$data['category_ids']);
                if (is_array($data['category_ids'])) {
                    $categoryIds =array_unique($data['category_ids']);
                    if(empty($categoryIds)){
                        $data['category_id'] ='';
                    }else{
                        $data['category_id'] = implode(',',$categoryIds);
                    }

                }
            }
            if(isset($data['pages']) && !empty($data['pages'])){
                if(empty($data['pages'][0])){
                    unset($data['pages'][0]);
                }
                if(!empty($data['pages'])){
                    //$pageIds = Mage::helper('core')->jsonEncode($data['pages']);
                    $pageIds =implode(',',$data['pages']);
                    $data['page_id'] = $pageIds;
                }else{
                    $data['page_id']='';
                }
            }

            $model->setData($data)->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bxslider')->__('Banner was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bxslider')->__('Unable to find Banner to save'));
        $this->_redirect('*/*/');
    }

    /**
     * @return location where we save uploaded image
     */
    public function getBaseTmpMediaUrl() {
        return Mage::getBaseUrl('media') . 'bxslider';
    }

    /**
     * @return path of uploaded image
     */
    public function getBaseTmpMediaPath()
    {
        return Mage::getBaseDir('media') . DS . 'bxslider';
    }


    protected function _prepareFileForUrl($file)
    {
        return str_replace(DS, '/', $file);
    }
}