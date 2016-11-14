# Gene_BraintreeCustomFields
This module outlines how you can easily send custom fields with a transactions when using the [Gene_Braintree](https://www.magentocommerce.com/magento-connect/braintree-payments-with-hosted-fields.html) module for Magento 1.

We implement a number of helpful events throughout the module that allow easy extension of various functionality. Notably we implement `gene_braintree_creditcard_sale_array` & `gene_braintree_paypal_sale_array` which allow other modules to intercept the modify the sale array sent over to Braintree.

## How to use these events
You'll need to craft a standard Magento module and within the modules `config.xml` you will need to declare an event for both the PayPal & Credit Card dependant on your requirements. In this example module we include events for both.

##### Credit Card Event:
```
<gene_braintree_creditcard_sale_array>
    <observers>
        <gene_braintree_creditcard_channel>
            <type>singleton</type>
            <class>gene_braintreecustomfields/observer</class>
            <method>addBraintreeCustomField</method>
        </gene_braintree_creditcard_channel>
    </observers>
</gene_braintree_creditcard_sale_array>
```

##### PayPal Event:
```
<gene_braintree_paypal_sale_array>
    <observers>
        <gene_braintree_paypal_channel>
            <type>singleton</type>
            <class>gene_braintreecustomfields/observer</class>
            <method>addBraintreeCustomField</method>
        </gene_braintree_paypal_channel>
    </observers>
</gene_braintree_paypal_sale_array>
```

Once you've implemented the above required events you can implement the logic required to build up your custom fields to be passed onto Braintree.

## Data passed to these events

These events are fired with two pieces of data passed to them:

- `request`: The request contains 1 piece of data under `sale_array`. Once retrieving the request within the event you can use the magic functions to get and set the sale array. Through `getSaleArray()` & `setSaleArray()`.
- `payment`: The original payment object used throughout the payment method.

## Retrieving data in the event
To retrieve the passed data in this event you'll need to access it through the `$observer` parameter as per the below.
```
public function addBraintreeCustomField(Varien_Event_Observer $observer)
{
    $request = $observer->getEvent()->getRequest();
    if ($salesArray = $request->getSaleArray()) {
        $salesArray['field'] = 'value';
        $request->setSaleArray($salesArray);
    }

    return $this;
}
```
