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
     * Creates RoxyFileManager CKEditor options.
     *
     * @clientOptions another CKEDitor client options.
     * @return array
     */
    public static function attach($cleintOptions = [])
    {
        $managerUrl = Yii::$app->urlManager->createUrl('/ckeditorRoxyFileman/default');
        return ArrayHelper::merge([
            'filebrowserBrowseUrl' => $managerUrl.'?type=media',
            'filebrowserImageBrowseUrl' => $managerUrl.'?type=image',
            'filebrowserFlashBrowseUrl' => $managerUrl.'?type=media',
        ], $cleintOptions);
    }
}
