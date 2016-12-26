# yii2-fleep

## Installation

`composer require white43/yii2-fleep`

## Config

* Open config/web.php of your Yii2 app
* Make necessary changes

```
$config = [
    'components' => [
        'log' => [
            'targets' => [
                'fleep' => [
                    'class' => white43\Fleep\FleepTarget::class,
                    'levels' => ['error', 'warning'],
                    'hook' => 'INSERT_YOUR_HOOK_ID_HERE',
                ],
            ],
        ],
    ],
];
```

* Profit!
