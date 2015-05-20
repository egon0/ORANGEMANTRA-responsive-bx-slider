<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 12:05
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Model_Mysql4_Bxslider extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('bxslider/bxslider', 'bxslider_id');
    }
}