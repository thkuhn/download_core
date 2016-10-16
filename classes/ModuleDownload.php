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
				$strPath = 'system/tmp/'. md5(uniqid(mt_rand(), true));
				$strName = standardize($objDownload->title) . '.zip';
				$objArchive = new \ZipWriter($strPath);

				foreach($objDownload->fileSRC as $fileSRC)
				{
					$objFile = \FilesModel::findByUuid($fileSRC);
					$objArchive->addFile($objFile->path, basename($objFile->path));
				}

				$objArchive->close();
				break;

			case 'single':
				if (is_array($objDownload->fileSRC))
				{
					$objDownload->fileSRC = $objDownload->fileSRC[0];
				}

				$objFile = \FilesModel::findByUuid($objDownload->fileSRC);
				$strPath = $objFile->path;
				$strName = standardize($objDownload->title) . '.' . $objFile->extension;

				break;

			case 'multi':
			default:
				$intFileIndex = 0;

				if (\Input::get('fileIndex') > 0)
				{
					$intFileIndex = (int) \Input::get('fileIndex');
				}

				$objFile = \FilesModel::findByUuid($objDownload->fileSRC[$intFileIndex]);
				$strPath = $objFile->path;
				$strName = standardize($objDownload->title) . (\Input::get('fileIndex', '') != '' ? '-' . ($intFileIndex + 1) : '') . '.' . $objFile->extension;

				break;
		}

		$objFile = new \File($strPath, true);
		$objFile->sendToBrowser($strName);
	}
}
