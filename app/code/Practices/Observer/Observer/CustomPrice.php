<?php

namespace Practices\Observer\Observer;

use Magento\Framework\Event\ObserverInterface;
class CustomPrice implements ObserverInterface
{

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);
        $price = $item->getProduct()->getPriceInfo()->getPrice('final_price')->getValue();
        $new_price = $price - ($price * 50 / 100); //discount the price of the product to 50%
        $item->setCustomPrice($new_price);
        $item->setOriginalCustomPrice($new_price);
        $item->getProduct()->setIsSuperMode(true);
    }
}