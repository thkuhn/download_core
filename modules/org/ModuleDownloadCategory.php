<?php

namespace CDK\Frontend;

class ModuleDownloadCategory extends \Module
{
	protected $strTemplate = 'mod_download_category';

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

		if(FE_USER_LOGGED_IN)
		{
			$this->Import('FrontendUser', 'Member');
		}

		return parent::generate();
	}

	protected function compile()
	{
		if(\Input::get('download'))
		{
			$objDownload = $this->Database->prepare("SELECT * FROM tl_download_item WHERE id=?")->execute(\Input::get('download'));

			if($this->hasAccess($objDownload))
			{
				if(\Validator::isUuid($objDownload->fileSRC))
				{
					$objFile = \FilesModel::findByUuid($objDownload->fileSRC);
					$this->sendFileToBrowser($objFile->path);
				}
				else
				{
					$fileSRC = deserialize($objDownload->fileSRC);
					$objFile = \FilesModel::findByUuid($fileSRC[0]);
					$this->sendFileToBrowser($objFile->path);
				}
			}
		}

		$objPage = \PageModel::findById($GLOBALS['objPage']->id);
		$strUrl = $this->generateFrontendUrl($objPage->row(), '/download/%s');

		$objCategory = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE alias=?")->execute(\Input::get('category'));
		$objArchiv   = $this->Database->prepare("SELECT * FROM tl_download_archiv WHERE id=?")->execute($objCategory->pid);

		$objData = $this->Database->prepare("SELECT * FROM tl_download_item WHERE pid=? && published=1 ORDER BY sorting ASC")->execute($objCategory->id);
		while($objData->next())
		{
			$objItem = (object) $objData->row();
			$objItem->archiv = $objArchiv->title;

			if($objCategory->singleSRC)
			{
				$objItem->archivIcon = \FilesModel::findByUuid($objCategory->singleSRC)->path;
			}

			$objItem->category = $objCategory->title;
			$objItem->singleSRC = deserialize($objItem->singleSRC);

			$arrImages = array();
			if(is_array($objItem->singleSRC))
			{
				foreach($objItem->singleSRC as $image)
				{
					$arrImages[] = (object) array
					(
						'css'  => '',
						'path' => \FilesModel::findByUuid($image)->path
					);
				}

				$arrImages[0]->css = 'first';
			}

			if($this->hasAccess($objItem))
			{
				$objItem->url = sprintf($strUrl, $objItem->id);
				$objItem->css = 'active';
				$objItem->preview = $arrImages;
			}
			else
			{
				$objItem->css = 'inactive';
				$objItem->preview = array($arrImages[0]);

			}

			$arrData[] = $objItem;
		}

		$this->Template->items = is_array($arrData) ? $arrData : array();
	}

	private function hasAccess($item)
	{
		if($item->protected)
		{
			if(FE_USER_LOGGED_IN)
			{
				$groups = deserialize($item->groups);
				if(is_array($groups))
				{
					foreach($groups as $group)
					{
						if(in_array($group, $this->Member->groups))
						{
							return true;
						}
					}
				}
			}
		}
		elseif(!$item->protected)
		{
			return true;
		}

		return false;
	}
}
