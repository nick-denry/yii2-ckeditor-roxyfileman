CKEditor integration
---
### Example

I.e. with [2amigos/yii2-ckeditor-widget](https://github.com/2amigos/yii2-ckeditor-widget)

In your view
```php
use dosamigos\ckeditor\CKEditor;
use nickdenry\ckeditorRoxyFileman\RoxyFileManager;
```

And then
```php
$form->field($model, 'body')->widget(CKEditor::className(), [
    'preset' => 'full',
    'clientOptions' => RoxyFileManager::attach([/* another ckeditor options */]),
]);
```
