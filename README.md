# JplararEnviapaqueteriaBundle
A simple Symfony2 bundle for the API for Envia Paqueteria API.

## Setup

### Step 1: Download JplararEnviapaqueteriaBundle using composer

Add SES Bundle in your composer.json:

```js
{
    "require": {
        "jplarar/enviapaqueteria-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update "jplarar/enviapaqueteria-bundle"
```


### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Jplarar\SESBundle\JplararEnviapaqueteriaBundle()
    );
}
```

### Step 3: Add configuration

``` yml
# app/config/config.yml
jplarar_enviapaqueteria:
        enviapaqueteria_keys:
              enviapaqueteria_user:    %enviapaqueteria_user%
              enviapaqueteria_password: %enviapaqueteria_password%
              enviapaqueteria_environment: %enviapaqueteria_environment% # 'prod' or 'dev'
```

## Usage

**Using service**

``` php
<?php
        $enviapaqueteriaClient = $this->get('enviapaqueteria_client');
?>
```

##Example

###Generate Quote
``` php
<?php 
    $quotes = $enviapaqueteriaClient->quote(
                    $origin[
                        "representative" => "Origen test",
                        "company" => "Origen Empresa",
                        "email" => "correo@pruebas.com",
                        "phone" => "8111234567",
                        "country" => "MX",
                        "address1" => "av vasconcelos",
                        "address2" => "1400",
                        "addressExtra" => "enfrente de office depot",
                        "zipCode" => "66240"
                    ], 
                    $destination[
                        "representative" => "Destino test",
                        "company" => "Origen Empresa",
                        "email" => "correo@pruebas.com",
                        "phone" => "8111234567",
                        "country" => "MX",
                        "address1" => "av vasconcelos",
                        "address2" => "1400",
                        "addressExtra" => "enfrente de office depot",
                        "zipCode" => "66240"
                    ], 
                    $options[
                        "content" => "vestido",
                        "insurance" => 0,
                        "value" => "",
                        "height" => 10,
                        "width" => 10,
                        "length" => 10,
                        "weight" => 2,
                        "amount" => 1,
                        "collection" => null,
                        "collection_time" => "",
                        "collection_time_limit" => "",
                        "collection_date" => ""
                    ]
            );
            
    $shipping = $enviapaqueteriaClient->create(
                    $provider[
                        "name" => "fedex",
                        "service" => "FEDEX_EXPRESS_SAVER"   
                     ],
                    $origin[
                        "representative" => "Origen test",
                        "company" => "Origen Empresa",
                        "email" => "correo@pruebas.com",
                        "phone" => "8111234567",
                        "country" => "MX",
                        "address1" => "av vasconcelos",
                        "address2" => "1400",
                        "addressExtra" => "enfrente de office depot",
                        "zipCode" => "66240"
                    ], 
                    $destination[
                        "representative" => "Destino test",
                        "company" => "Origen Empresa",
                        "email" => "correo@pruebas.com",
                        "phone" => "8111234567",
                        "country" => "MX",
                        "address1" => "av vasconcelos",
                        "address2" => "1400",
                        "addressExtra" => "enfrente de office depot",
                        "zipCode" => "66240"
                    ], 
                    $options[
                        "content" => "vestido",
                        "insurance" => 0,
                        "value" => "",
                        "height" => 10,
                        "width" => 10,
                        "length" => 10,
                        "weight" => 2,
                        "amount" => 1,
                        "collection" => null,
                        "collection_time" => "",
                        "collection_time_limit" => "",
                        "collection_date" => "",
                        "file" => "PDF",
                        "paper" => "PAPER_7X4.75",
                    ]
                );
?>
```
