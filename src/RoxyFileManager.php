<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * {@inheritDoc}
 */
class RoxyFileManager
{
    /**
     * Return filemanager Url
     */
    public static function getUrl($type = 'image')
    {
        $managerUrl = Yii::$app->urlManager->createUrl('/ckeditorRoxyFileman/default').'?type='.$type;
        return $managerUrl;
    }
    /**
     * Creates RoxyFileManager CKEditor options.
     *
     * @clientOptions another CKEDitor client options.
     * @return array
     */
    public static function attach($cleintOptions = [])
    {

        return ArrayHelper::merge([
            'filebrowserBrowseUrl' => self::getUrl('media'),
            'filebrowserImageBrowseUrl' => self::getUrl('image'),
            'filebrowserFlashBrowseUrl' => self::getUrl('media'),
        ], $cleintOptions);
    }
}
