<?php

/**
 * Class Gene_BraintreeCustomFields_Model_Observer
 *
 * @author Dave Macaulay <dave@gene.co.uk>
 */
class Gene_BraintreeCustomFields_Model_Observer
{
    /**
     * Add in Braintree custom field to sale array
     *
     * @param \Varien_Event_Observer $observer
     *
     * @return $this
     */
    public function addBraintreeCustomField(Varien_Event_Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        if ($salesArray = $request->getSaleArray()) {
            $salesArray['field'] = 'value';
            $request->setSaleArray($salesArray);
        }

        return $this;
    }
}