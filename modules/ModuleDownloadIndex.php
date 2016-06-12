<?php

namespace pixelSpreadde\Frontend;
use pixelSpreadde\Models, pixelSpreadde\Classes;

class ModuleDownloadIndex extends \Module 
{
	protected $strTemplate = 'mod_download_index';

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
		$objPage = \PageModel::findById($this->jumpTo);
		$strUrl = \Controller::generateFrontendUrl($objPage->row(), '/%s/%s');

		$arrData = array();
		$objArchiv = \DownloadArchivModel::findByIds(deserialize($this->download_archiv));
		if($objArchiv !== null) {
			while($objArchiv->next()) {

				$arrSubitems = array();
				$objCategory = \DownloadCategoryModel::findByPid($objArchiv->id);
				if($objCategory !== null) {
					while($objCategory->next()) {
						$objSub = (object) $objCategory->row();
						$objSub->url = sprintf($strUrl, 'category', $objSub->alias);

						$arrSubitems[] = $objSub;
					}
				}

				$objItem = (object) $objArchiv->row();
				$objItem->url = sprintf($strUrl, 'archiv', $objItem->alias);
				$objItem->subitems = $arrSubitems;

				$arrData[] = $objItem;
			}
		}

		$this->Template->items = $arrData;
	}
}