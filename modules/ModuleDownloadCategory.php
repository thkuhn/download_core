<?php

namespace pixelSpreadde\Frontend;
use pixelSpreadde\Models, pixelSpreadde\Classes;

class ModuleDownloadCategory extends \Module 
{
	protected $strTemplate = 'mod_download_category';

	public function generate() 
	{
		if (TL_MODE == 'BE') 
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . strtoupper($GLOBALS['TL_LANG']['FMD'][$this->type][0]) . ' ###';
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
		$strUrl = \Controller::generateFrontendUrl($objPage->row(), '/element/%s');

		$objArchiv   = \DownloadArchivModel::findByAlias(\Input::Get('category'));
		$objCategory = \DownloadCategoryModel::findByPid($objArchiv->id);

		while($objCategory->next()) {
			$objItem = (object) $objCategory->row();
			$objElement = \DownloadItemModel::findByPid($objCategory->id);

			if($objElement !== null) {
				while($objElement->next()) {
#					echo $objElement->title;
				}
			}

			$arrData[] = $objItem;
		}

		$this->Template->items = $arrData;
	}
}