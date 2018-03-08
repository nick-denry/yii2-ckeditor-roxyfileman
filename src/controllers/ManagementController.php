<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman\controllers;

use nickdenry\ckeditorRoxyFileman\helpers\FileHelper;
use nickdenry\ckeditorRoxyFileman\helpers\FolderHelper;
use nickdenry\ckeditorRoxyFileman\models\UploadForm;
use nickdenry\ckeditorRoxyFileman\Module;
use Yii;
use yii\base\ErrorException;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * @property Module $module
 */
class ManagementController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                '*' => [
                    'GET',
                    'AJAX',
                ],
                'file-upload' => [
                    'POST',
                    'AJAX',
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * @param        $name
     * @param string $folder
     *
     * @return array
     */
    public function actionFolderCreate($name, $folder = '')
    {
        if ($folder == '') {
            $folder = Yii::getAlias($this->module->uploadFolder);
        }
        $folder = realpath($folder);
        if (is_dir($folder)) {
            if (file_exists($folder . DIRECTORY_SEPARATOR . $name)) {
                $response = [
                    'error' => 1,
                    'message' => Yii::t('ckeditorRoxyFileman', 'Folder existed'),
                ];
            } else {
                if (mkdir($folder . DIRECTORY_SEPARATOR . $name, 0777, true)) {
                    $response = [
                        'error' => 0,
                        'message' => Yii::t('ckeditorRoxyFileman', 'Folder created'),
                        'data' => [
                            'href' => Url::to([
                                '/ckeditorRoxyFileman/management/file-list',
                                'folder' => $folder . DIRECTORY_SEPARATOR . $name,
                            ]),
                            'text' => $name,
                            'path' => $folder . DIRECTORY_SEPARATOR . $name,
                        ],
                    ];
                } else {
                    $response = [
                        'error' => 1,
                        'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t create folder in {0}', [$folder]),
                    ];
                }
            }
        } else {
            $response = [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Invalid directory {0}', [$folder]),
            ];
        }
        return $response;
    }

    /**
     * @param string $folder
     *
     * @return array
     */
    public function actionFolderList($folder = '')
    {
        if ($folder == '') {
            $folder = Yii::getAlias($this->module->uploadFolder);
        }
        $folder = realpath($folder);
        $content = FolderHelper::folderList($folder);
        return [
            'error' => 0,
            'content' => $content,
        ];
    }

    /**
     * @param string $folder
     * @param string $sort
     *
     * @return array
     */
    public function actionFileList($folder = '', $sort = '')
    {
        /**
         * @var Module $module
         */
        $module = Yii::$app->getModule('ckeditorRoxyFileman');
        $folder = realpath($folder);
        if ($folder == '') {
            $folder = Yii::getAlias($this->module->uploadFolder);
        }
        if ($module->rememberLastFolder) {
            Yii::$app->cache->set('ckeditorRoxyFileman_last_folder', $folder);
        }
        if ($sort == '') {
            if ($module->rememberLastOrder && Yii::$app->cache->exists('ckeditorRoxyFileman_last_order')) {
                $sort = Yii::$app->cache->get('ckeditorRoxyFileman_last_order');
            } else {
                $sort = FolderHelper::SORT_DATE_DESC;
            }
        }
        if ($module->rememberLastOrder) {
            Yii::$app->cache->set('ckeditorRoxyFileman_last_order', $sort);
        }
        $content = [];
        foreach (FolderHelper::fileList($folder, $sort) as $item) {
            $file = $folder . DIRECTORY_SEPARATOR . $item;
            $content[] = [
                'is_image' => FileHelper::isImage($item),
                'url' => FileHelper::fileUrl($file),
                'preview' => FileHelper::filePreview($file),
                'icon' => FileHelper::fileIcon($file),
                'name' => $item,
                'size' => FileHelper::fileSize(filesize($file), 0),
                'date' => date($module->dateFormat, filemtime($file)),
            ];
        }
        return [
            'error' => 0,
            'content' => $content,
        ];
    }

    /**
     * @param string $folder
     * @param        $name
     *
     * @return array
     */
    public function actionFolderRename($folder = '', $name)
    {
        if ($folder == '') {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t rename root folder'),
            ];
        }
        $folder = realpath($folder);
        $newFolder = dirname($folder) . DIRECTORY_SEPARATOR . $name;
        if (rename($folder, $newFolder)) {
            return [
                'error' => 0,
                'data' => [
                    'href' => Url::to([
                        '/ckeditorRoxyFileman/management/file-list',
                        'folder' => $newFolder,
                    ]),
                    'text' => $name,
                    'path' => $newFolder,
                ],
            ];
        } else {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
            ];
        }
    }

    /**
     * @param        $folder
     * @param string $parentFolder
     *
     * @return array
     */
    public function actionFolderRemove($folder, $parentFolder = '')
    {
        $folder = realpath($folder);
        $folderProperties = FolderHelper::folderList($folder);
        if ($folderProperties != null && isset($folderProperties[0]['nodes']) && $folderProperties[0]['nodes'] != null) {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Please remove all sub-folder before'),
            ];
        }
        foreach (FolderHelper::fileList($folder) as $file) {
            unlink($folder . DIRECTORY_SEPARATOR . $file);
        }
        try {
            if (rmdir($folder)) {
                return [
                    'error' => 0,
                    'content' => $parentFolder,
                ];
            } else {
                return [
                    'error' => 1,
                    'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
                ];
            }
        } catch (ErrorException $e) {
            if ($e->getCode() == 2) {
                return [
                    'error' => 1,
                    'message' => Yii::t('ckeditorRoxyFileman', 'Please remove all sub-folder before'),
                ];
            }
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
            ];
        }
    }

    /**
     * @param string $folder
     *
     * @return array
     */
    public function actionFileUpload($folder = '')
    {
        if ($folder == '') {
            $folder = Yii::getAlias($this->module->uploadFolder);
        }
        $folder = realpath($folder);
        if (is_dir($folder)) {
            $model = new UploadForm();
            $model->file = UploadedFile::getInstances($model, 'file');
            if ($model->upload($folder)) {
                return [
                    'error' => 0,
                ];
            } else {
                if (isset($model->firstErrors['file'])) {
                    return [
                        'error' => 1,
                        'message' => $model->firstErrors['file'],
                    ];
                }
            }
        }
        return [
            'error' => 1,
            'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
        ];
    }

    /**
     * @param string $folder
     * @param        $file
     * @param        $name
     *
     * @return array
     */
    public function actionFileRename($folder = '', $file, $name)
    {
        if ($folder == '') {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t rename this file'),
            ];
        }
        $folder = realpath($folder);
        $oldFile = $folder . DIRECTORY_SEPARATOR . $file;
        $newFile = $folder . DIRECTORY_SEPARATOR . $name;
        if (is_file($oldFile) && rename($oldFile, $newFile)) {
            return [
                'error' => 0,
                'data' => [
                    'href' => Url::to([
                        '/ckeditorRoxyFileman/management/file-list',
                        'folder' => $folder,
                    ]),
                    'name' => $name,
                ],
            ];
        } else {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
            ];
        }
    }

    public function actionFileRemove($folder = '', $file)
    {
        if ($folder == '') {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t remove this file'),
            ];
        }
        $folder = realpath($folder);
        $filePath = $folder . DIRECTORY_SEPARATOR . $file;
        if (is_file($filePath) && unlink($filePath)) {
            return [
                'error' => 0,
            ];
        } else {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
            ];
        }
    }

    /**
     * This help move file from current directory to everywhere
     *
     * @param $folder string path of current file
     * @param $file   string new path
     *
     * @return array
     */
    public function actionFileCut($folder, $file)
    {
        if ($folder == '') {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t cut this file'),
            ];
        }
        $folder = realpath($folder);
        $filePath = $folder . DIRECTORY_SEPARATOR . $file;
        if (Yii::$app->session->hasFlash('ckeditorRoxyFileman_copy')) {
            Yii::$app->session->removeFlash('ckeditorRoxyFileman_copy');
        }
        Yii::$app->session->setFlash('ckeditorRoxyFileman_cut', $filePath);
        return [
            'error' => 0,
        ];
    }

    /**
     * This help to copy file
     *
     * @param $folder string path of current file
     * @param $file   string new path
     *
     * @return array
     */
    public function actionFileCopy($folder, $file)
    {
        if ($folder == '') {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t copy this file'),
            ];
        }
        $folder = realpath($folder);
        $filePath = $folder . DIRECTORY_SEPARATOR . $file;
        if (Yii::$app->session->hasFlash('ckeditorRoxyFileman_cut')) {
            Yii::$app->session->removeFlash('ckeditorRoxyFileman_cut');
        }
        Yii::$app->session->setFlash('ckeditorRoxyFileman_copy', $filePath);
        return [
            'error' => 0,
        ];
    }

    /**
     * @param $folder
     *
     * @return array
     */
    public function actionFilePaste($folder)
    {
        if ($folder == '') {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Can\'t past the clipboard'),
            ];
        }
        $folder = realpath($folder);
        $filePath = null;
        $return = false;
        if (Yii::$app->session->hasFlash('ckeditorRoxyFileman_cut')) {
            $filePath = Yii::$app->session->getFlash('ckeditorRoxyFileman_cut');
            $return = rename($filePath, $folder . DIRECTORY_SEPARATOR . basename($filePath));
        } else if (Yii::$app->session->hasFlash('ckeditorRoxyFileman_copy')) {
            $filePath = Yii::$app->session->getFlash('ckeditorRoxyFileman_copy');
            $return = copy($filePath, $folder . DIRECTORY_SEPARATOR . basename($filePath));
        }
        if ($return && $filePath != null) {
            return [
                'error' => 0,
            ];
        } else {
            return [
                'error' => 1,
                'message' => Yii::t('ckeditorRoxyFileman', 'Somethings went wrong'),
            ];
        }
    }
}
