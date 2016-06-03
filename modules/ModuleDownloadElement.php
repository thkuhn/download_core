<?php

namespace pixelSpreadde\Frontend;

class ModuleDownloadElement extends \Module 
{
	protected $strTemplate = 'mod_download_element';

	public function generate() 
	{
		if (TL_MODE == 'BE') 
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### DMS LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	protected function compile()
	{
#		$strTmp = md5(uniqid(mt_rand(), true));
#		$objArchive = new \ZipWriter('system/tmp/'. $strTmp);
		if(\Input::Get('download') && FE_USER_LOGGED_IN)
		{
			$objDownload = $this->Database->prepare("SELECT * FROM tl_download_item WHERE id=?")->execute(\Input::Get('download'));
			$objFile = \FilesModel::findByUuid($objDownload->fileSRC);

			$this->sendFileToBrowser($objFile->path);
		}

		$objPage = \PageModel::findById($GLOBALS['objPage']->id);
		$strUrl = $this->generateFrontendUrl($objPage->row(), '/download/%s');

		$objCategory = $this->Database->prepare("SELECT * FROM tl_download_category WHERE alias=?")->execute(\Input::Get('category'));
		$objArchiv   = $this->Database->prepare("SELECT * FROM tl_download_archiv WHERE id=?")->execute($objCategory->pid);

		$objData = $this->Database->prepare("SELECT * FROM tl_download_item WHERE pid=? && published=1 ORDER BY sorting ASC")->execute($objCategory->id);
		while($objData->next())
		{
			$objItem = (object) $objData->row();

#			$objItem->archiv = $objArchiv->title;
#
#			if($objCategory->singleSRC)
#			{
#				$objItem->archivIcon = \FilesModel::findByUuid($objCategory->singleSRC)->path;
#			}
#
#			$objItem->category = $objCategory->title;
#			$objItem->singleSRC = deserialize($objItem->singleSRC);
#
#			$arrImages = array();
#			if(is_array($objItem->singleSRC))
#			{
#				foreach($objItem->singleSRC as $image)
#				{
#					$arrImages[] = (object) array
#					(
#						'css'  => '',
#						'path' => \FilesModel::findByUuid($image)->path
#					);
#				}
#
#				$arrImages[0]->css = 'first';
#			}
#
#
#			if(FE_USER_LOGGED_IN)
#			{
#				$objItem->url = sprintf($strUrl, $objItem->id);
#				$objItem->css = 'active';
#				$objItem->preview = $arrImages;
#			}
#			else
#			{
#				$objItem->css = 'inactive';
#				$objItem->preview = array($arrImages[0]);
#
#			}

			$arrData[] = $objItem;
		}

#		if(!count($arrDaata)) { $arrData = array(); }

		$this->Template->items = $arrData;
	}
}