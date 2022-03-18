# Simple PHP Library to list and send Push Notification with OneSignal Service

## Installation
```php
composer require sureshchand/onesignal-notification
```

# Examples

### Initial Setup
```php
<?php
require "vendor/autoload.php";

$api_id = 'API_ID';
$rest_api_key = 'REST_API_KEY';

$pushNotification = new \Suresh\Onesignal\Notification($api_id, $rest_api_key);
```
### Create notification
#### Send to all subscribers
```php
<?php
$pushNotification->setBody('English Message')
                 ->setSegments('All')
                 ->prepare()
                 ->send();
```
#### Send to a specific segment
```php
<?php
$pushNotification->setBody('English Message')
                 ->setSegments('Active Users')
                 ->prepare()
                 ->send();
```
#### Send based on filters/tags
```php
<?php
$pushNotification->setBody('English Message')
                 ->setFilter([
                     ['field' => 'tag', 'key' => 'level', 'relation' => '>', 'value' => '10'],
                     ['operator' => 'OR'],
                     ['field' => 'amount_spent', 'relation' => '>', 'value' => '0']
                 ])
                 ->prepare()
                 ->send();
```
#### Send based on OneSignal PlayerIds
```php
<?php
$pushNotification->setBody('English Message')
                 ->setPlayersId([
                    'PLAYER_ID',
                    'ANOTHER_PLAYER_ID' 
                 ])
                 ->prepare()
                 ->send();
```

## Reference guideline
[OneSignal API Reference](https://documentation.onesignal.com/reference)
