<?php

namespace pixelSpreadde\Frontend;

class ModuleDownloadArchiv extends \Module 
{
	protected $strTemplate = 'mod_download_archiv';

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
		$objPage = \PageModel::findById($this->jumpTo);
		$strUrl = $this->generateFrontendUrl($objPage->row(), '/category/%s');

		$objData   = $this->Database->prepare("SELECT * FROM tl_download_archiv WHERE id IN(" . implode(",", $this->download_archiv) . ") && published=?")->execute(1);
		while($objData->next())
		{
#			$objCount = $this->Database->prepare("SELECT * FROM tl_download_item WHERE pid=? && published=1 ORDER BY sorting ASC")->execute($objData->id);

			$objItem = (object) $objData->row();
			$objItem->url = sprintf($strUrl, $objItem->alias);
			$objItem->count = $objCount->count();

			if($objData->singleSRC)
			{
				$objItem->archivIcon = \FilesModel::findByUuid($objData->singleSRC)->path;
			}

			$arrData[] = $objItem;
		}

		$this->Template->items = $arrData;
	}
}