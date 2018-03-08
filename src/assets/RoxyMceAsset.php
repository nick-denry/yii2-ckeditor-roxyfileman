<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */

namespace nickdenry\ckeditorRoxyFileman\assets;

use Yii;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * {@inheritDoc}
 */
class RoxyMceAsset extends AssetBundle
{

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = '@vendor/nick-denry/yii2-ckeditor-roxyfileman/src/web';
        $this->depends = [
            'yii\web\JqueryAsset',
            'yii\bootstrap\BootstrapAsset',
            'yii\bootstrap\BootstrapPluginAsset',
            'nickdenry\ckeditorRoxyFileman\assets\FontAwesomeAsset',
            'nickdenry\ckeditorRoxyFileman\assets\BootstrapTreeviewAsset',
            'nickdenry\ckeditorRoxyFileman\assets\LazyLoadAsset',
            'nickdenry\ckeditorRoxyFileman\assets\FancyBoxAsset',
            'nickdenry\ckeditorRoxyFileman\assets\ContextMenuAsset',
        ];
        $this->css = [
            YII_ENV_DEV ? 'css/roxy.css' : 'css/roxy.min.css',
        ];
        $this->js = [
            YII_ENV_DEV ? 'js/roxy.js' : 'js/roxy.min.js',
        ];
        Yii::$app->view->registerJs('var msg_somethings_went_wrong = "' . Yii::t('ckeditorRoxyFileman', 'Somethings went wrong') . '",
msg_empty_directory = "' . Yii::t('ckeditorRoxyFileman', 'Empty directory') . '",
msg_please_select_one_folder = "' . Yii::t('ckeditorRoxyFileman', 'Please select one folder') . '",
msg_are_you_sure = "' . Yii::t('ckeditorRoxyFileman', 'Are you sure?') . '",
msg_preview = "' . Yii::t('ckeditorRoxyFileman', 'Preview') . '",
msg_download = "' . Yii::t('ckeditorRoxyFileman', 'Download') . '",
msg_cut = "' . Yii::t('ckeditorRoxyFileman', 'Cut') . '",
msg_copy = "' . Yii::t('ckeditorRoxyFileman', 'Copy') . '",
msg_paste = "' . Yii::t('ckeditorRoxyFileman', 'Paste') . '",
msg_rename = "' . Yii::t('ckeditorRoxyFileman', 'Rename') . '",
msg_delete = "' . Yii::t('ckeditorRoxyFileman', 'Delete') . '",
url_folder_remove = "' . Url::to(['/ckeditorRoxyFileman/management/folder-remove']) . '",
url_file_upload = "' . Url::to(['/ckeditorRoxyFileman/management/file-upload']) . '",
url_file_cut = "' . Url::to(['/ckeditorRoxyFileman/management/file-cut']) . '",
url_file_copy = "' . Url::to(['/ckeditorRoxyFileman/management/file-copy']) . '",
url_file_paste = "' . Url::to(['/ckeditorRoxyFileman/management/file-paste']) . '",
url_file_remove = "' . Url::to(['/ckeditorRoxyFileman/management/file-remove']) . '";
		', View::POS_HEAD);
    }
}
