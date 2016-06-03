<?php

namespace pixelSpreadde\Frontend;
use pixelSpreadde\Models, pixelSpreadde\Classes;

class ModuleDownloadArchiv extends \Module 
{
	protected $strTemplate = 'mod_download_archiv';

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
		$strUrl = \Controller::generateFrontendUrl($objPage->row(), '/category/%s');

		$objArchiv = \DownloadArchivModel::findByIds(deserialize($this->download_archiv));
		if($objArchiv !== null) {
			while($objArchiv->next())
			{
#				$objCount = $this->Database->prepare("SELECT * FROM tl_download_item WHERE pid=? && published=1 ORDER BY sorting ASC")->execute($objData->id);

				$objItem = (object) $objArchiv->row();
				$objItem->url = sprintf($strUrl, $objItem->alias);
#				$objItem->count = $objCount->count();

				if($objItem->addImage) {
					$objFile = \FilesModel::findByUuid($objItem->singleSRC);
					$objImage = new \FrontendTemplate();

					$this->addImageToTemplate($objImage, array (
						'addImage'    => 1,
						'singleSRC'   => $objFile->path,
						'alt'         => null,
						'size'        => $this->dms_imageSize,
						'imagemargin' => $this->dms_imageMargin,
						'imageUrl'    => $objItem->url,
						'caption'     => null,
						'floating'    => $this->dms_imageFloating,
						'fullsize'    => $this->dms_imageFullsize
					), null,'id' . $objItem->imageSrc_thumb);

					$objItem->image = $objImage;
				}

				$arrData[] = $objItem;
			}

			$arrData[0]->css = ' first';
			$arrData[count($arrData) - 1]->css = ' last';
		}

		$this->Template->items = $arrData;
	}
}