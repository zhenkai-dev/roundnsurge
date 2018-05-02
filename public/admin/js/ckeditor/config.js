/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';

    var browsePath = '../../';

    config.allowedContent = true;
    config.contentsCss = ['/admin/css/bootstrap.min.css', '/admin/css/ckeditor.css'];

    config.toolbar =
        [
            [ 'Source' ],
            [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ],
            [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ],
            [ 'NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ],
            '/',
            [ 'Styles','Format','Font','FontSize' ],
            [ 'TextColor','BGColor' ],
            [ 'Link','Unlink','Anchor' ],
            [ 'Image','Flash','HorizontalRule','SpecialChar' ]
        ];

    config.toolbarCanCollapse = false;
    config.scayt_autoStartup = false;

    config.filebrowserBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=flash';
};