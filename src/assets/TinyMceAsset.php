<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * {@inheritDoc}
 */
class TinyMceAsset extends AssetBundle
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->depends = [
            'yii\web\YiiAsset',
        ];
        $this->sourcePath = '@bower/tinymce';
        $this->js = ['tinymce.min.js'];
        $this->jsOptions = ['position' => View::POS_HEAD];
    }
}
