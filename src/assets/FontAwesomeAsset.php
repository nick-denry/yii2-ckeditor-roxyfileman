<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\assets;

use yii\web\AssetBundle;

/**
 * This will register asset for FontAwesome
 * {@inheritDoc}
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->depends = [
            'yii\web\JqueryAsset',
        ];
        if (file_exists(\Yii::getAlias('@bower/font-awesome'))) {
            $this->sourcePath = '@bower/font-awesome';
        } else {
            $this->sourcePath = '@bower/fontawesome';
        }
        $this->css = [
            'css/font-awesome.min.css',
        ];
    }
}
