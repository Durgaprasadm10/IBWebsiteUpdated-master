/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	config.skins = 'office2003';
	config.width = '860';
        config.hight = '550';
	
	config.extraPlugins = 'divarea,div,stylescombo';		
	
	config.allowedContent = true; 	
	
	config.toolbar = 'Full';
 
	config.toolbar_Full =
	[
		{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'insert1', items : [ 'Image','Flash','Table'] },
		{ name: 'insert2', items : [ 'HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
			'HiddenField' ] },			
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },		
		{ name: 'paragraph1', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-'] },
		{ name: 'paragraph2', items : ['Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'links', items : [ 'Link','Unlink'] },		
		
		'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];
	 
	config.toolbar_Basic =
	[
		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
	];
};



CKEDITOR.config.filebrowserBrowseUrl = 'lib/ckeditor/ckfinder/ckfinder.html';
   CKEDITOR.config.filebrowserImageBrowseUrl = 'lib/ckeditor/ckfinder/ckfinder.html?type=Images';
   CKEDITOR.config.filebrowserFlashBrowseUrl = 'lib/ckeditor/ckfinder/ckfinder.html?type=Flash';
   CKEDITOR.config.filebrowserUploadUrl = 'lib/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   CKEDITOR.config.filebrowserImageUploadUrl = 'lib/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   CKEDITOR.config.filebrowserFlashUploadUrl = 'lib/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
