Handle files after upload
---

Every file could be processed with global `ckeditorRoxyFileman.fileUploaded` event, i.e. for create thumbnails for images.

### Example

Add event and handler to app config, i.e. `backend\config\main.php`
```php
'modules' => [],
'on ckeditorRoxyFileman.fileUploaded' => [
    'backend\helpers\ThumbnailHelper', 'createThumbnail`'
],
```

Thumbnail helper with your favourite graphics library, i.e. [yii2-imagine](https://github.com/yiisoft/yii2-imagine)
```php
<?php
namespace backend\helpers;

// use Imagine\Image\Box; 
// etc

class ThumbnailHelper {
    public static function createThumbnail($event) {
        \Yii::info($event->fileName); // $event->fileName contains filesystem full path to file 
        // Some thumbnail operations
    }
}
```
