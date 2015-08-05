<?php
 /**
* Ti Order Comment Module
*
* @category    Ti
* @package     Ti_OrderComment
* @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
* @link        http://www.titechnologies.in
*/

class Ti_OrderComment_Block_Checkout_Agreements extends Mage_Checkout_Block_Agreements
{
    /**
     * Override block template
     *
     * @return string
     */



    protected function _toHtml()
    {
        $status = Mage::getStoreConfig('ordercomment/ordercomment_group/ordercomment_enable');
        if($status==1) {
            $this->setTemplate('ordercomment/checkout/agreements.phtml');
            return parent::_toHtml();
        }
    }
}
