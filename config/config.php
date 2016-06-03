<?php

array_insert($GLOBALS['BE_MOD']['content'], count($GLOBALS['BE_MOD']['content']), array
(
	'download' => array
	(
		'tables'     => array('tl_download_archiv', 'tl_download_category', 'tl_download_item'),
		'icon'       => 'system/themes/default/images/sync.gif'
	)
));

array_insert($GLOBALS['FE_MOD']['download_core'], 0, array
(
    'download_archiv'            => 'ModuleDownloadArchiv',
    'download_category'          => 'ModuleDownloadCategory'
));

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('pixelSpreadde\Classes\InsertTags', 'myReplaceInsertTags');

$GLOBALS['TL_HEAD']['PIXELSPREADDE'] = '<!--
    This Contao OpenSource CMS uses modules from pixelSpread.de
    Copyright (c)2012 - ' . date("Y") . ' by Sascha Brandhoff :: Extensions of pixelSpread.de are copyright of their respective owners
    Visit our website at http://www.pixelSpread.de for more information
//-->';