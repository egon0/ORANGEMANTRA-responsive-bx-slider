<?php
/**
 * @author: Pardeep Kumar <pardeep19@gmail.com>
 * @since: 15-01-2015 11:58
 * @copyright: All right reserved.
 * created by IntelliJ IDEA
 */

class OM_BxSlider_Block_Adminhtml_Bxslider_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('bxsliderGrid');
        $this->setDefaultSort('bxslider_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('bxslider/bxslider')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('bxslider_id', array(
            'header'    => Mage::helper('bxslider')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'bxslider_id',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('bxslider')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('bxslider')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bxslider')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bxslider')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}