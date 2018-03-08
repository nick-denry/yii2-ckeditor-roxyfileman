<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ContextMenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nick-denry/yii2-ckeditor-roxyfileman/src/web';
    public $css = [
        'css/jquery.contextMenu.min.css',
    ];
    public $js = [
        'js/jquery.contextMenu.min.js',
    ];
    public $jsOptions = ['position' => View::POS_HEAD];
}
