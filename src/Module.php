<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 */
namespace nickdenry\ckeditorRoxyFileman;

use Yii;
use yii\base\InvalidParamException;

/**
 * {@inheritDoc}
 */
class Module extends \navatech\base\Module
{
    /**
     * @var string default folder which will be used to upload resource
     *             must be start with @
     */
    public $uploadFolder = '@app/web/uploads/images';

    /**
     * @var string url of $uploadFolder
     *             not include 'http://domain.com'
     *             must be start with /
     */
    public $uploadUrl = '/uploads/images';

    /**
     * @var string default view type
     */
    public $defaultView = 'thumb';

    /**
     * @var string default display dateFormat
     * @see http://php.net/manual/en/function.date.php
     */
    public $dateFormat = 'Y-m-d H:i';

    /**
     * @var bool would you want to remember last folder?
     */
    public $rememberLastFolder = true;

    /**
     * @var bool would you want to remember last sort order?
     */
    public $rememberLastOrder = true;
    
    /**
    * @var bool would you want to resize image?
    **/
    public $imageResize = false;
    
    /**
    * @var integer image width for resize
    **/
    public $image_width = 600;
    
    /**
    * @var integer image height for resize
    **/
    public $image_height = 400;
    
    /**
     * @var string default allowed files extension
     */
    public $allowExtension = 'jpeg jpg png gif svg mov mp3 mp4 avi wmv flv mpeg webm ogg';

    /**
     * Initializes the module.
     *
     * This method is called after the module is created and initialized with property values
     * given in configuration. The default implementation will initialize [[controllerNamespace]]
     * if it is not set.
     *
     * If you override this method, please make sure you call the parent implementation.
     * @throws InvalidParamException
     */
    public function init()
    {
        parent::init();
        if (!is_dir(Yii::getAlias($this->uploadFolder))) {
            mkdir(Yii::getAlias($this->uploadFolder), 0777, true);
        }
        if (!Yii::$app->cache->exists('ckeditorRoxyFileman_last_order')) {
            Yii::$app->cache->set('ckeditorRoxyFileman_last_folder', Yii::getAlias($this->uploadFolder));
        }
    }
}
