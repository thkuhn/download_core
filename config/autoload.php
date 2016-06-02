<?php

ClassLoader::addNamespaces(array
(
	'pixelSpreadde\Models',
	'pixelSpreadde\Classes',
	'pixelSpreadde\Frontend',
	'pixelSpreadde\Elements',
	'pixelSpreadde\Controller'
));
 
ClassLoader::addClasses(array
(
	'pixelSpreadde\Classes\InsertTags'              => 'system/modules/download_core/classes/InsertTags.php',

	'pixelSpreadde\Frontend\ModuleDownloadArchiv'   => 'system/modules/download_core/modules/ModuleDownloadArchiv.php',
	'pixelSpreadde\Frontend\ModuleDownloadCategory' => 'system/modules/download_core/modules/ModuleDownloadCategory.php'
));

TemplateLoader::addFiles(array
(
	'mod_download_archiv'   => 'system/modules/download_core/templates/modules/',
	'mod_download_category' => 'system/modules/download_core/templates/modules/'
));