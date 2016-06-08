Yii2 images , загружка отображение изображений
=====================


## Install
```
php composer.phar require --prefer-dist mitrm/yii2-images-module "dev-master"
```


- Run migrations:

```
php yii migrate --migrationPath=@mitrm/images/migrations
```

In config file:

```php
    'modules' => [
        'short_link' => [
            'class' => 'mitrm\images\Module',
            'domain' => site.ru // домен отображения изображений
        ],
    ],
```

## Usage
