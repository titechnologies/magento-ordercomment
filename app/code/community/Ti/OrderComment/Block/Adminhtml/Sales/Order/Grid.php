<?php
 /**
* Ti Order Comment Module
*
* @category    Ti
* @package     Ti_OrderComment
* @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
* @link        http://www.titechnologies.in
*/

class Ti_OrderComment_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    /**
     * Columns, that become ambiguous after join
     *
     * @var array
     */


    protected $_ambiguousColumns = array(
        'status',
        'created_at',
    );

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        $status = Mage::getStoreConfig('ordercomment/ordercomment_group/ordercomment_enable');
        if($status==1) {
            return 'ordercomment/order_grid_collection';
        }
        else
            return parent::_getCollectionClass();
    }

    /**
     * Prepare grid columns
     *
     * @return Ti_OrderComment_Block_Adminhtml_Sales_Order_Grid
     */
    protected function _prepareColumns()
    {
        $status = Mage::getStoreConfig('ordercomment/ordercomment_group/ordercomment_enable');
        if($status==1) {

            parent::_prepareColumns();
            // Add order comment to grid
            $this->addColumn('ordercomment', array(
                'header'       => Mage::helper('ordercomment')->__('Order Comment'),
                'index'        => 'ordercomment',
                'filter_index' => 'ordercomment_table.comment',
            ));

            // Fix integrity constraint violation in SELECT
            foreach ($this->_ambiguousColumns as $index) {
                if (isset($this->_columns[$index])) {
                    $this->_columns[$index]->setFilterIndex('main_table.' . $index);
                }
            }

            return $this;
        }
        else
            return parent::_prepareColumns();
    }

    /**
     * Prepare grid massactions
     *
     * @return Ti_OrderComment_Block_Adminhtml_Sales_Order_Grid
     */
    protected function _prepareMassaction()
    {
        parent::_prepareMassaction();

        // VERY dirty hack to resolve conflict with Seamless Delete Order
        $modules = (array)Mage::getConfig()->getNode('modules')->children();
        if (isset($modules['EM_DeleteOrder']) && $modules['EM_DeleteOrder']->is('active')) {
            $this->getMassactionBlock()->addItem('delete_order', array(
               'label'=> Mage::helper('sales')->__('Delete order'),
               'url'  => $this->getUrl('*/sales_order/deleteorder'),
            ));
        }
        return $this;
    }
}
