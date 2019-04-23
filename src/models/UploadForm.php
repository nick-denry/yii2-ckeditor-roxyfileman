<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */

namespace nickdenry\ckeditorRoxyFileman\models;

use nickdenry\ckeditorRoxyFileman\helpers\FileHelper;
use nickdenry\ckeditorRoxyFileman\Module;
use yii\base\Model;
use yii\web\UploadedFile;
use Imagine\Image\Box;
use yii\imagine\Image;

class UploadForm extends Model
{
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
        $module = \Yii::$app->getModule('ckeditorRoxyFileman');
        if ($this->validate()) {
            foreach ($this->file as $file) {
                $filePath = $folder . DIRECTORY_SEPARATOR . FileHelper::removeSign($file->baseName) . '.' . $file->extension;
                if (file_exists($filePath)) {
                    $filePath = $folder . DIRECTORY_SEPARATOR . FileHelper::removeSign($file->baseName) . '_' . time() . '.' . $file->extension;
                }
                $file->saveAs($filePath);
                $mime = explode('/', mime_content_type($filePath));
                if(isset($mime[0]) && $mime[0] == 'image' && $module->imageResize == true){
                    Image::getImagine()->open($filePath)->thumbnail(new Box($module->imageWidth, $module->imageHeight))->save($filePath , ['quality' => $module->imageQuality]);
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
