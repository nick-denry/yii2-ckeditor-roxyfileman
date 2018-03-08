Standalone usage
---
Just use with fancybox, bootstrap modal (currently only support fancybox 2.x and bootstrap 3.x).
### Property
* `type` type of displayed media. **Required**. Value:
  * `image`
  * `media`
* `dialog` type of dialog. **Required**. Supported:
  * `fancybox`
  * `modal`
* `input` input's ID. **Required**

### Example

#### With Fancybox
```php
<?php
use nickdenry\ckeditorRoxyFileman\assets\BootstrapTreeviewAsset;
use nickdenry\ckeditorRoxyFileman\assets\FancyBoxAsset;
use nickdenry\ckeditorRoxyFileman\assets\FontAwesomeAsset;
use nickdenry\ckeditorRoxyFileman\assets\LazyLoadAsset;
use yii\helpers\Url;

FontAwesomeAsset::register($this);
LazyLoadAsset::register($this);
FancyBoxAsset::register($this);
BootstrapTreeviewAsset::register($this);
?>
<input type="text" id="fieldID">
<a class="fancybox" data-fancybox-type="iframe" href="<?= Url::to([
    RoxyFileManager::getUrl(),
    'type'   => 'image',
    'input'  => 'fieldID',
    'dialog' => 'fancybox',
]) ?>">Click to show Roxy Filemanager</a>
<script>
    $('.fancybox').fancybox();
</script>
```

#### With Bootstrap modal
```php
<?php
use nickdenry\ckeditorRoxyFileman\assets\BootstrapTreeviewAsset;
use nickdenry\ckeditorRoxyFileman\assets\FancyBoxAsset;
use nickdenry\ckeditorRoxyFileman\assets\FontAwesomeAsset;
use nickdenry\ckeditorRoxyFileman\assets\LazyLoadAsset;
use nickdenry\ckeditorRoxyFileman\RoxyFileManager;

FontAwesomeAsset::register($this);
LazyLoadAsset::register($this);
FancyBoxAsset::register($this);
BootstrapTreeviewAsset::register($this);
?>
<input type="text" id="fieldID2">
<a class="btn btn-primary" data-toggle="modal" href="" data-target="#modal-id" data-remote="false">Trigger modal</a>
<div class="modal modal-roxy fade" id="modal-id">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <iframe src="<?= Url::to([
                                RoxyFileManager::getUrl(),
                                'type'   => 'image',
                                'input'  => 'fieldID2',
                                'dialog' => 'modal',
                        ]) ?>" height="470px" width="100%"></iframe>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
```
