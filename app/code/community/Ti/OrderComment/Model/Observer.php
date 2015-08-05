<?php
 /**
* Ti Order Comment Module
*
* @category    Ti
* @package     Ti_OrderComment
* @copyright   Copyright (c) 2014 Ti Technologies (http://www.titechnologies.in)
* @link        http://www.titechnologies.in
*/

class Ti_OrderComment_Model_Observer extends Varien_Object
{
    /**
     * Save comment from agreement form to order
     *
     * @param $observer
     */
    public function saveOrderComment($observer)
    {
        $customComment = "";
        $orderComment = Mage::app()->getRequest()->getPost('ordercomment');
        $customComment = Mage::app()->getRequest()->getPost('custom_comment');

        if (is_array($orderComment) && isset($orderComment['comment']) && $customComment!='') {

            $comment = trim($orderComment['comment']);
            $cust_comment = trim($customComment);
            $commentCombined = '['.$comment.'] '.$cust_comment;

            if (!empty($comment)) {

                $order = $observer->getEvent()->getOrder();
                $order->setCustomerComment($commentCombined);
                $order->setCustomerNoteNotify(true);
                $order->setCustomerNote($commentCombined);
            }
        }
        else if (is_array($orderComment) && isset($orderComment['comment']) && $customComment=='') {

            $comment = trim($orderComment['comment']);

            if (!empty($comment)) {

                $order = $observer->getEvent()->getOrder();
                $order->setCustomerComment($comment);
                $order->setCustomerNoteNotify(true);
                $order->setCustomerNote($comment);
            }
        }
        else if ($orderComment=='' && $customComment!='') {

                $cust_comment = trim($customComment);
                $order = $observer->getEvent()->getOrder();
                $order->setCustomerComment($cust_comment);
                $order->setCustomerNoteNotify(true);
                $order->setCustomerNote($cust_comment);

        }

    }
}
