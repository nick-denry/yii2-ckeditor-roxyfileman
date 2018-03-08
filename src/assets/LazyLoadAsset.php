<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\assets;

use yii\web\AssetBundle;
use yii\web\View;

class LazyLoadAsset extends AssetBundle
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->js = [
            'jquery.lazyload.js',
        ];
        $this->depends = [
            'yii\web\JqueryAsset',
        ];
        if (file_exists(\Yii::getAlias('@bower/jquery_lazyload'))) {
            $this->sourcePath = '@bower/jquery_lazyload';
        } else {
            $this->sourcePath = '@bower/jquery.lazyload';
        }
        $this->jsOptions = [
            'position' => View::POS_HEAD,
        ];
    }
}
