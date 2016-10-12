<?php

namespace CDK\Classes;

abstract class ModuleDownload extends \Module
{
	public function sendDownloadToBrowser($downloadId=0)
	{
		$objDownload = $this->Database->prepare("SELECT * FROM tl_download_item WHERE id=?")->execute($downloadId);
		$objDownload->fileSRC = deserialize($objDownload->fileSRC);
		switch($objDownload->type)
		{
			case 'zipper':
				$strTemp = 'system/tmp/'. md5(uniqid(mt_rand(), true));
				$strName = standardize($objDownload->title) . '.zip';
				$objArchive = new \ZipWriter($strTemp);

				foreach($objDownload->fileSRC as $fileSRC)
				{
					$objFile = \FilesModel::findByUuid($fileSRC);
					$objArchive->addFile($objFile->path, basename($objFile->path));
				}

				$objArchive->close();
				break;
			case 'single':
			case 'multi':
			default:
				$objFile = \FilesModel::findByUuid($objDownload->fileSRC[0]);
				$strTemp = $objFile->path;
				$strName = standardize($objDownload->title) .  substr($objFile->path, strrpos($objFile->path, "."));

				break;
		}

		$objFile = new \File($strTemp, true);
		$objFile->sendToBrowser($strName);
	}
}
