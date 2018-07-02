<?php

namespace Practices\Observer\Observer;

use Magento\Framework\Event\ObserverInterface;


class CustomerLogout implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        echo "Customer LoggedIn";
        $customer = $observer->getEvent()->getCustomer();
        echo $customer->getName(); //Get customer name
        exit;
    }
}