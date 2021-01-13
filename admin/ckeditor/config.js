/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'en';
	// config.uiColor = '#AADC6E';

config.allowedContent = true;

config.extraPlugins = "doksoft_advanced_blocks,doksoft_alert,doksoft_backup,doksoft_breadcrumbs,doksoft_button," +
"doksoft_custom_templates,doksoft_easy_file,doksoft_easy_image,doksoft_easy_preview,doksoft_file," +
"doksoft_font_awesome,doksoft_gallery,doksoft_image,doksoft_image_embed,doksoft_include,doksoft_maps," +
"doksoft_preview,doksoft_rehost_file,doksoft_rehost_image,doksoft_special_symbols,doksoft_syn,doksoft_table," +
"doksoft_translater,doksoft_youtube";

config.extraPlugins = 'doksoft_custom_templates,doksoft_easy_file,doksoft_easy_image,doksoft_easy_preview,doksoft_file,doksoft_gallery,doksoft_image,doksoft_image_embed,doksoft_include,doksoft_maps,';

config.filebrowserUploadUrl = "filemanager/upload/";

config.toolbar = [
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
    '/',
    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
    { name: 'others', items: [ '-' ] },
    { name: 'about', items: [ 'About' ] },
	'/',
    { name: 'doksoft', items: ['doksoft_image_embed', '-', 'doksoft_easy_image', 'doksoft_easy_preview', 'doksoft_easy_file', '-', 'doksoft_image', 'doksoft_preview', 'doksoft_file', 'doksoft_gallery', '-', 'doksoft_rehost_image', 'doksoft_rehost_file', '-', 'doksoft_advanced_blocks', 'doksoft_maps', 'doksoft_youtube', 'doksoft_font_awesome', 'doksoft_alert', 'doksoft_breadcrumbs', 'doksoft_button', 'doksoft_custom_templates', 'doksoft_special_symbols', 'doksoft_syn', 'doksoft_table', '-', 'doksoft_translater', 'doksoft_translater_settings', 'doksoft_translater_reverse', 'doksoft_backup_save', 'doksoft_backup_load'] }
];
};


