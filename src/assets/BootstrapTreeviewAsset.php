<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\assets;

use yii\web\AssetBundle;
use yii\web\View;

class BootstrapTreeviewAsset extends AssetBundle
{
    public $sourcePath = '@bower/patternfly-bootstrap-treeview/dist';
    public $js = ['bootstrap-treeview.min.js'];
    public $css = ['bootstrap-treeview.min.css'];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
    public $jsOptions = ['position' => View::POS_HEAD];
}
