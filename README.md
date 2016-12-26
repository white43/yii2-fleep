# yii2-fleep

## Installation

`composer require white43/yii2-fleep`

## Config

1. Open config/web.php
2. Make necessary changes

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

3. Profit!
