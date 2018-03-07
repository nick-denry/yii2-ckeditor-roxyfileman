<?php
/**
 * Created by Navatech.
 * @project yii2-roxy-ckeditor
 * @author  Le Phuong
 * @email   phuong17889[at]gmail.com
 * @date    15/02/2016
 * @time    10:24 SA
 * @version 2.0.0
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
