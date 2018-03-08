<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FancyBoxAsset extends AssetBundle
{
    public $sourcePath = '@bower/fancybox/source';
    public $js = ['jquery.fancybox.pack.js'];
    public $css = ['jquery.fancybox.css'];
    public $jsOptions = ['position' => View::POS_HEAD];
}
