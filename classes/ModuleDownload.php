<?php

namespace pixelSpreadde\Classes;

abstract class ModuleDownload extends \Module
{
	public function sendDownloadToBrowser($downloadId=0)
	{
		$objDownload = $this->Database->prepare("SELECT * FROM tl_download_item WHERE id=?")->execute($downloadId);
		$objDownload->fileSRC = deserialize($objDownload->fileSRC);

		switch($objDownload->type)
		{
			case 'single':
			case 'multi':
				$objFile = \FilesModel::findByUuid($objDownload->fileSRC[0]);
				$strTemp = $objFile->path;
				$strName = standardize($objDownload->title) .  substr($objFile->path, strrpos($objFile->path, "."));
				break;;
			case 'zipper':
				$strTmp = 'system/tmp/'. md5(uniqid(mt_rand(), true));
				$strName = standardize($objDownload->title) . '.zip';
				$objArchive = new \ZipWriter($strTmp);

				foreach($objDownload->fileSRC as $fileSRC)
				{
					$objFile = \FilesModel::findByUuid($fileSRC);
					$objArchive->addFile($objFile->path);
				}

				$objArchive->close();
				break;;
			default:

				break;;

		}

		$objFile = new \File($strTemp, true);
		$objFile->sendToBrowser($strName);
	}
}
