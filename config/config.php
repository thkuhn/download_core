<?php

array_insert($GLOBALS['BE_MOD']['content'], count($GLOBALS['BE_MOD']['content']), array
(
	'download' => array
	(
		'tables'     => array('tl_download_structure', 'tl_download_item'),
		'icon'       => 'system/themes/default/images/sync.gif'
	)
));

array_insert($GLOBALS['FE_MOD']['download_core'], 0, array
(
	'download_archiv'            => 'ModuleDownloadArchiv',
	'download_category'          => 'ModuleDownloadCategory',
	'download_index'             => 'ModuleDownloadIndex',
	'download_navigation'        => 'ModuleDownloadNavigation'
));

array_insert($GLOBALS['TL_CTE']['files'], count($GLOBALS['TL_CTE']['files']), array
(
	'download_archive' => 'ContentDownloadArchive'
));

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('CDK\Classes\InsertTags', 'myReplaceInsertTags');

$GLOBALS['TL_HEAD']['PIXELSPREADDE'] = '<!--
    This Contao OpenSource CMS uses modules from pixelSpread.de
    Copyright (c)2012 - ' . date("Y") . ' by Sascha Brandhoff :: Extensions of pixelSpread.de are copyright of their respective owners
    Visit our website at http://www.pixelSpread.de for more information
//-->';