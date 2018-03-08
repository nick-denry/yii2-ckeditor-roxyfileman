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
    public static function getUrl()
    {
        $managerUrl = Yii::$app->urlManager->createUrl('/ckeditorRoxyFileman/default');
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
            'filebrowserBrowseUrl' => self::getUrl().'?type=media',
            'filebrowserImageBrowseUrl' => self::getUrl().'?type=image',
            'filebrowserFlashBrowseUrl' => self::getUrl().'?type=media',
        ], $cleintOptions);
    }
}
