<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 12:03
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Model_Bxslider extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('bxslider/bxslider');
    }
}