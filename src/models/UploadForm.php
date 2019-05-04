<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */

namespace nickdenry\ckeditorRoxyFileman\models;

use nickdenry\ckeditorRoxyFileman\events\FileEvent;
use nickdenry\ckeditorRoxyFileman\helpers\FileHelper;
use nickdenry\ckeditorRoxyFileman\Module;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    
    const EVENT_FILE_UPLOADED = 'ckeditorRoxyFileman.fileUploaded';
    
    /**
     * @var UploadedFile[]
     */
    public $file;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        /*         * @var Module $module */
        $module = \Yii::$app->getModule('ckeditorRoxyFileman');
        return [
            [
                ['file'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => implode(',', explode(' ', $module->allowExtension)),
                'maxFiles' => 20,
            ],
        ];
    }

    /**
     * @param $folder
     *
     * @return bool
     */
    public function upload($folder)
    {
        if ($this->validate()) {
            foreach ($this->file as $file) {
                $filePath = $folder . DIRECTORY_SEPARATOR . FileHelper::removeSign($file->baseName) . '.' . $file->extension;
                if (file_exists($filePath)) {
                    $filePath = $folder . DIRECTORY_SEPARATOR . FileHelper::removeSign($file->baseName) . '_' . time() . '.' . $file->extension;
                }
                $file->saveAs($filePath);
                $event = new FileEvent();
                $event->fileName = $filePath;
                \Yii::$app->trigger(self::EVENT_FILE_UPLOADED, $event);
            }
            return true;
        } else {
            return false;
        }
    }
}
