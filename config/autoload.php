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
	'pixelSpreadde\Models\DownloadArchivModel'      => 'system/modules/download_core/models/DownloadArchivModel.php',
	'pixelSpreadde\Models\DownloadCategoryModel'    => 'system/modules/download_core/models/DownloadCategoryModel.php',
	'pixelSpreadde\Models\DownloadItemModel'        => 'system/modules/download_core/models/DownloadItemModel.php',

	'pixelSpreadde\Classes\InsertTags'              => 'system/modules/download_core/classes/InsertTags.php',
	'pixelSpreadde\Classes\ModuleDownload'          => 'system/modules/download_core/classes/ModuleDownload.php',

	'pixelSpreadde\Frontend\ModuleDownloadArchiv'   => 'system/modules/download_core/modules/ModuleDownloadArchiv.php',
	'pixelSpreadde\Frontend\ModuleDownloadCategory' => 'system/modules/download_core/modules/ModuleDownloadCategory.php',
	'pixelSpreadde\Frontend\ModuleDownloadElement'  => 'system/modules/download_core/modules/ModuleDownloadElement.php',
	'pixelSpreadde\Frontend\ModuleDownloadIndex'    => 'system/modules/download_core/modules/ModuleDownloadIndex.php'
));

TemplateLoader::addFiles(array
(
	'category_boxed'        => 'system/modules/download_core/templates/listing',
	'category_download'     => 'system/modules/download_core/templates/listing',
	'category_list'         => 'system/modules/download_core/templates/listing',

	'mod_download_archiv'   => 'system/modules/download_core/templates/modules',
	'mod_download_category' => 'system/modules/download_core/templates/modules',
	'mod_download_element'  => 'system/modules/download_core/templates/modules',
	'mod_download_index'    => 'system/modules/download_core/templates/modules'
));