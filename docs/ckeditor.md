CKEditor integration
---

To integrate the `nick-denry/yii2-ckeditor-roxyfileman` into [2amigos/yii2-ckeditor-widget](https://github.com/2amigos/yii2-ckeditor-widget), one should take note of the urlManager settings as well as thie RoxyFileman takes the link format of the one with ```enablePrettyUrl``` set to ```true```. In windows IIS, please follow the guide from [here - the clearest guide I found yet](https://stackoverflow.com/questions/49494959/how-to-propper-configure-web-config-on-iis-to-publish-yii2-advanced) to setup URL Rewrite before proceeding.

### Example

I.e. with [2amigos/yii2-ckeditor-widget](https://github.com/2amigos/yii2-ckeditor-widget)

In your view
```php
<?php
use dosamigos\ckeditor\CKEditor;
use nickdenry\ckeditorRoxyFileman\RoxyFileManager;
```

And then
```php
<?php
$form->field($model, 'body')->widget(CKEditor::className(), [
    'preset' => 'full',
    'clientOptions' => RoxyFileManager::attach([/* another ckeditor options */]),
]);
```
