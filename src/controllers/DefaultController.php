<?php
/**
 * Created by Navatech.
 * @project yii2-roxy-ckeditor
 * @author  Le Phuong
 * @email   phuong17889[at]gmail.com
 * @date    15/02/2016
 * @time    4:19 CH
 * @version 2.0.0
 */
namespace nickdenry\ckeditorRoxyFileman\controllers;

use nickdenry\ckeditorRoxyFileman\helpers\FolderHelper;
use nickdenry\ckeditorRoxyFileman\models\UploadForm;
use nickdenry\ckeditorRoxyFileman\Module;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * {@inheritDoc}
 */
class DefaultController extends Controller
{
    /**
     * Render a view
     *
     * @param $type
     *
     * @return string
     */
    public function actionIndex($type)
    {
        /*         * @var Module $module */
        $module = Yii::$app->getModule('ckeditorRoxyFileman');
        $uploadForm = new UploadForm();
        $defaultFolder = '';
        $defaultOrder = FolderHelper::SORT_DATE_DESC;
        Yii::$app->cache->set('ckeditorRoxyFileman_file_type', $type);
        if ($module->rememberLastFolder && Yii::$app->cache->exists('ckeditorRoxyFileman_last_folder')) {
            $defaultFolder = Yii::$app->cache->get('ckeditorRoxyFileman_last_folder');
        }
        if ($module->rememberLastOrder && Yii::$app->cache->exists('ckeditorRoxyFileman_last_order')) {
            $defaultOrder = Yii::$app->cache->get('ckeditorRoxyFileman_last_order');
        }
        $fileListUrl = Url::to([
            '/ckeditorRoxyFileman/management/file-list',
            'folder' => $defaultFolder,
            'sort' => $defaultOrder,
        ]);
        return $this->renderAjax('index', [
            'module' => $module,
            'uploadForm' => $uploadForm,
            'fileListUrl' => $fileListUrl,
            'defaultOrder' => $defaultOrder,
            'defaultFolder' => $defaultFolder,
        ]);
    }
}
