<?php
/**
 * @project yii2-ckeditor-roxyfileman
 * @author  Nick Denry
 *
 * @var View       $this
 * @var Module     $module
 * @var UploadForm $uploadForm
 * @var string     $defaultFolder
 * @var int        $defaultOrder
 * @var string     $fileListUrl
 */
use nickdenry\ckeditorRoxyFileman\assets\RoxyMceAsset;
use nickdenry\ckeditorRoxyFileman\helpers\FolderHelper;
use nickdenry\ckeditorRoxyFileman\models\UploadForm;
use nickdenry\ckeditorRoxyFileman\Module;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

RoxyMceAsset::register($this);
?>
<div class="wrapper container-fluid">
    <section class="body">
        <div class="row">
            <div class="col-sm-4 left-body">
                <div class="actions">
                    <button type="button" class="btn btn-sm btn-default ckeditor-dialog-ui-button" data-toggle="modal" href="#folder-create" title="<?= Yii::t('ckeditorRoxyFileman', 'Create new folder') ?>">
                        <span class="fa-stack fa-sm">
                            <i class="fa fa-folder fa-stack-2x" aria-hidden="true"></i>
                            <i class="fa fa-plus fa-stack-1x fa-inverse" aria-hidden="true"></i>
                        </span>
                        <?= Yii::t('ckeditorRoxyFileman', 'Create') ?>
                    </button>
                    <button type="button" class="btn btn-sm btn-default ckeditor-dialog-ui-button" data-toggle="modal" href="#folder-rename" title="<?= Yii::t('ckeditorRoxyFileman', 'Rename selected folder') ?>">
                        <span class="fa-stack fa-sm">
                            <i class="fa fa-folder fa-stack-2x" aria-hidden="true"></i>
                            <i class="fa fa-pencil fa-stack-1x fa-inverse" aria-hidden="true"></i>
                        </span> <?= Yii::t('ckeditorRoxyFileman', 'Rename') ?>
                    </button>
                    <button type="button" class="btn btn-sm btn-default btn-folder-remove ckeditor-dialog-ui-button" title="<?= Yii::t('ckeditorRoxyFileman', 'Delete selected folder') ?>">
                        <i class="fa fa-trash"></i> <?= Yii::t('ckeditorRoxyFileman', 'Delete') ?></button>
                </div>
                <div class="scrollPane folder-list" data-url="<?= Url::to(['/ckeditorRoxyFileman/management/folder-list']) ?>">
                    <div class="folder-list-item"></div>
                </div>
            </div>
            <div class="col-sm-8 right-body">
                <div class="actions first-row">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="btn btn-sm btn-default ckeditor-dialog-ui-button" title="<?= Yii::t('ckeditorRoxyFileman', 'Upload files') ?>">
                                <?=
                                Html::activeFileInput($uploadForm, 'file', [
                                    'multiple' => true,
                                    'name' => 'UploadForm[file][]',
                                    'data-href' => $fileListUrl,
                                    'data-url' => Url::to([
                                        '/ckeditorRoxyFileman/management/file-upload',
                                        'folder' => $defaultFolder,
                                    ]),
                                ])
                                ?>
                                <i class="fa fa-upload"></i> <?= Yii::t('ckeditorRoxyFileman', 'Upload file') ?>
                            </label>
                            <a class="btn btn-sm btn-default btn-file-preview ckeditor-dialog-ui-button" disabled="disabled" title="<?= Yii::t('ckeditorRoxyFileman', 'Preview selected file') ?>">
                                <i class="fa fa-search"></i> <?= Yii::t('ckeditorRoxyFileman', 'Preview') ?>
                            </a>
                            <button type="button" class="btn btn-sm btn-default btn-file-rename ckeditor-dialog-ui-button" disabled="disabled" title="<?= Yii::t('ckeditorRoxyFileman', 'Rename file') ?>" data-toggle="modal" href="#file-rename">
                                <i class="fa fa-pencil"></i> <?= Yii::t('ckeditorRoxyFileman', 'Rename file') ?>
                            </button>
                            <a class="btn btn-sm btn-default btn-file-download ckeditor-dialog-ui-button" disabled="disabled" title="<?= Yii::t('ckeditorRoxyFileman', 'Download file') ?>">
                                <i class="fa fa-download"></i> <?= Yii::t('ckeditorRoxyFileman', 'Download') ?>
                            </a>
                            <button type="button" class="btn btn-sm btn-default btn-file-remove ckeditor-dialog-ui-button" disabled="disabled" title="<?= Yii::t('ckeditorRoxyFileman', 'Delete file') ?>">
                                <i class="fa fa-trash"></i> <?= Yii::t('ckeditorRoxyFileman', 'Delete file') ?>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="actions second-row">
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="button" data-action="switch_view" data-name="list_view" class="btn btn-default <?= $module->defaultView != 'list' ?: 'btn-primary' ?>" title="<?= Yii::t('ckeditorRoxyFileman', 'List view') ?>">
                                <i class="fa fa-list"></i>
                            </button>
                            <button type="button" data-action="switch_view" data-name="thumb_view" class="btn btn-default <?= $module->defaultView != 'thumb' ?: 'btn-primary' ?>" title="<?= Yii::t('ckeditorRoxyFileman', 'Thumbnails view') ?>">
                                <i class="fa fa-picture-o"></i>
                            </button>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-inline">
                                <div class="form-group form-group-sm form-search">
                                    <input id="txtSearch" type="text" class="form-control" placeholder="<?= Yii::t('ckeditorRoxyFileman', 'Search for...') ?>">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="file-body">
                    <div class="scrollPane file-list" data-url="<?= $fileListUrl ?>">
                        <div class="sort-actions" style="display: <?= $module->defaultView == 'list' ? 'block' : 'none' ?>;">
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="pull-left <?= ($defaultOrder == FolderHelper::SORT_NAME_ASC || $defaultOrder == FolderHelper::SORT_NAME_DESC) ? 'sorted' : '' ?>" rel="order" data-order="name" data-sort="<?= $defaultOrder == FolderHelper::SORT_NAME_ASC ? 'asc' : 'desc' ?>">
                                        <i class="fa fa-long-arrow-up"></i>
                                        <i class="fa fa-long-arrow-down"></i>
                                        <span> <?= Yii::t('ckeditorRoxyFileman', 'Name') ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="pull-right <?= ($defaultOrder == FolderHelper::SORT_SIZE_ASC || $defaultOrder == FolderHelper::SORT_SIZE_DESC) ? 'sorted' : '' ?>" rel="order" data-order="size" data-sort="<?= $defaultOrder == FolderHelper::SORT_SIZE_ASC ? 'asc' : 'desc' ?>">
                                        <i class="fa fa-long-arrow-up"></i>
                                        <i class="fa fa-long-arrow-down"></i>
                                        <span> <?= Yii::t('ckeditorRoxyFileman', 'Size') ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="pull-right <?= ($defaultOrder == FolderHelper::SORT_DATE_ASC || $defaultOrder == FolderHelper::SORT_DATE_DESC) ? 'sorted' : '' ?>" rel="order" data-order="date" data-sort="<?= $defaultOrder == FolderHelper::SORT_DATE_ASC ? 'asc' : 'desc' ?>">
                                        <i class="fa fa-long-arrow-up"></i>
                                        <i class="fa fa-long-arrow-down"></i>
                                        <span> <?= Yii::t('ckeditorRoxyFileman', 'Date') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="file-list-item"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="footer">
        <div class="row bottom">
            <div class="col-sm-6 pull-left">
                <div class="progress" style="display: none;">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">

                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-sm-offset-3 pull-right">
                <button type="button" class="btn btn-success btn-ckeditorRoxyFileman-select" disabled title="<?= Yii::t('ckeditorRoxyFileman', 'Select highlighted file') ?>">
                    <i class="fa fa-check"></i> <?= Yii::t('ckeditorRoxyFileman', 'Select') ?>
                </button>
                <button type="button" class="btn btn-default btn-ckeditorRoxyFileman-close">
                    <i class="fa fa-times"></i> <?= Yii::t('ckeditorRoxyFileman', 'Close') ?>
                </button>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="folder-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= Yii::t('ckeditorRoxyFileman', 'Create new folder') ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?= Url::to(['/ckeditorRoxyFileman/management/folder-create']) ?>" method="get" role="form">
                    <input type="hidden" name="folder" value="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="folder_name" placeholder="<?= Yii::t('ckeditorRoxyFileman', 'Folder\'s name') ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-submit"><?= Yii::t('ckeditorRoxyFileman', 'Save') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('ckeditorRoxyFileman', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="folder-rename">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= Yii::t('ckeditorRoxyFileman', 'Rename selected folder') ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?= Url::to(['/ckeditorRoxyFileman/management/folder-rename']) ?>" method="get" role="form">
                    <input type="hidden" name="folder" value="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="folder_name" placeholder="<?= Yii::t('ckeditorRoxyFileman', 'Folder\'s name') ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-submit"><?= Yii::t('ckeditorRoxyFileman', 'Save') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('ckeditorRoxyFileman', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="file-rename">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= Yii::t('ckeditorRoxyFileman', 'Rename selected file') ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?= Url::to(['/ckeditorRoxyFileman/management/file-rename']) ?>" method="get" role="form">
                    <input type="hidden" name="folder" value="">
                    <input type="hidden" name="file" value="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="file_name" placeholder="<?= Yii::t('ckeditorRoxyFileman', 'File\'s name') ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-submit"><?= Yii::t('ckeditorRoxyFileman', 'Save') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('ckeditorRoxyFileman', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
</script>
