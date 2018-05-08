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
    $result = $enviapaqueteriaClient->sendEmail(
                'recipient@example.com', 
                'subject', 
                'sender@example.com', 
                '<h1>AWS Amazon Simple Email Service Test Email</h1>',
                'This email was send with Amazon SES using the AWS SDK for Symfony.'
            );
            
            $messageId = $result->get('MessageId');
            echo("Email sent! Message ID: $messageId"."\n");
?>
```
