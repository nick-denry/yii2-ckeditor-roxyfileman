Module configure
---

One should include this module array in the Yii2 framework under the configuration file. For advanced template users, you can find this file under `backend/config/main.php` and `frontend/config/main.php` folders.

### Property

The following properties can be set in the ckeditorRoxyFileman object to specify the instances behaviour

* `uploadFolder` the directory where stored files. Default is `@app/web/uploads/images`. If folder not existed, roxy will auto-create it.
* `uploadUrl` the url which can get folder link. Default is `/uploads/images`. If you are using `yii2-advanced` should include scheme (`http://frontend.domain.com/uploads/images`).
* `defaultView` display type. Default is `thumb`
* `dateFormat` Datetime format. Default is `Y-m-d H:i`. See: http://php.net/manual/en/function.date.php
* `rememberLastFolder` would you want to remember last folder? Default is `true`
* `rememberLastOrder` would you want to remember last order? Default is `true`
* `allowExtension` allowed files extension. Default is `jpeg jpg png gif mov mp3 mp4 avi wmv flv mpeg webm`

### Example
Add to config file:
```php
<?php
return [
    'modules' => [
        'ckeditorRoxyFileman' => [
            'class' => 'nickdenry\ckeditorRoxyFileman\Module',
            'uploadFolder' => '@frontend/web/uploads/images',
            'uploadUrl' => '/uploads/images',
        ],
    ],
];
?>
```
