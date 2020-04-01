/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	config.language = 'es';
	config.uiColor = '#4A75B5';
	config.skin = 'bootstrapck';
	config.toolbar_Basic = [
		{name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike']},
		{name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
		{name: 'links', items: ['Link', 'Unlink']}
	];
	config.disableNativeSpellChecker = false;
	config.removePlugins = 'contextmenu,liststyle,tabletools';
};