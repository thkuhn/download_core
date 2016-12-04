<?php

ClassLoader::addNamespaces(array
(
	'CDK\Models',
	'CDK\Classes',
	'CDK\Frontend',
	'CDK\Elements',
	'CDK\Controller'
));

ClassLoader::addClasses(array
(
	'CDK\Elements\ContentDownloadArchive'   => 'system/modules/download_core/elements/ContentDownloadArchive.php',

	'CDK\Models\DownloadArchivModel'        => 'system/modules/download_core/models/DownloadArchivModel.php',
	'CDK\Models\DownloadCategoryModel'      => 'system/modules/download_core/models/DownloadCategoryModel.php',
	'CDK\Models\DownloadItemModel'          => 'system/modules/download_core/models/DownloadItemModel.php',
	'CDK\Models\DownloadStructureModel'     => 'system/modules/download_core/models/DownloadStructureModel.php',

	'CDK\Classes\InsertTags'                => 'system/modules/download_core/classes/InsertTags.php',
	'CDK\Classes\ModuleDownload'            => 'system/modules/download_core/classes/ModuleDownload.php',
	'CDK\Classes\Downloads'                 => 'system/modules/download_core/classes/Downloads.php',

	'CDK\Frontend\ModuleDownloadArchiv'     => 'system/modules/download_core/modules/ModuleDownloadArchiv.php',
	'CDK\Frontend\ModuleDownloadCategory'   => 'system/modules/download_core/modules/ModuleDownloadCategory.php',
	'CDK\Frontend\ModuleDownloadElement'    => 'system/modules/download_core/modules/ModuleDownloadElement.php',
	'CDK\Frontend\ModuleDownloadIndex'      => 'system/modules/download_core/modules/ModuleDownloadIndex.php',
	'CDK\Frontend\ModuleDownloadNavigation' => 'system/modules/download_core/modules/ModuleDownloadNavigation.php'
));

TemplateLoader::addFiles(array
(
	'category_boxed'          => 'system/modules/download_core/templates/listing',
	'category_download'       => 'system/modules/download_core/templates/listing',
	'category_list'           => 'system/modules/download_core/templates/listing',

	'dn_node'                 => 'system/modules/download_core/templates/navigation',

	'mod_download_archiv'     => 'system/modules/download_core/templates/modules',
	'mod_download_category'   => 'system/modules/download_core/templates/modules',
	'mod_download_navigation' => 'system/modules/download_core/templates/modules'
));
