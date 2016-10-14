<?php

namespace CDK\Frontend;

use CDK\Classes\ModuleDownload;

class ModuleDownloadCategory extends ModuleDownload
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

		if(FE_USER_LOGGED_IN)
		{
			$this->Import('FrontendUser', 'Member');
		}

		if(\Input::get('category'))
		{
			$objCategory = \DownloadStructureModel::findByAlias(\Input::get('category'));
		}
		else
		{
			$blnStop = true;
		}

		$objDownloads = \DownloadItemModel::findByPid($objCategory->id);
		if($objDownloads !== null)
		{
			if(!$objDownloads->count())
			{
				$blnStop = true;
			}
		}
		else
		{
			$blnStop = true;
		}

		if($blnStop)
		{
			return '';
		}

		return parent::generate();
	}

	protected function compile()
	{
		if(\Input::get('downloadId') && FE_USER_LOGGED_IN)
		{
			$this->sendDownloadToBrowser(\Input::get('downloadId'));
		}

		$objPage = \PageModel::findById($GLOBALS['objPage']->id);
		$strUrl = \Controller::generateFrontendUrl($objPage->row(), '/element/%s');

		if(\Input::get('category'))
		{
			$objCategory = \DownloadStructureModel::findByAlias(\Input::get('category'));
		}

		$arrDownloads = array();
		$objDownloads = \DownloadItemModel::findByPid($objCategory->id);
		$objDownloads = $this->Database->prepare("SELECT * FROM tl_download_item WHERE pid=? ORDER BY sorting ASC")->execute($objCategory->id);

		if($objDownloads !== null)
		{
			while($objDownloads->next())
			{
				$objDownload = (object) $objDownloads->row();

				if($objDownload->addImage)
				{
					$arrFiles = array();
					foreach(deserialize($objDownload->singleSRC) as $file)
					{
						$arrFiles[] = \FilesModel::findByUuid($file);
					}

					$objDownload->singleSRC = $arrFiles;
					$objDownload->previewImage = $arrFiles[0];
				}

				$arrFiles = array();
				$index = 0;
				if(is_array(deserialize($objDownload->fileSRC)))
				{
					foreach(deserialize($objDownload->fileSRC) as $file)
					{
						$objFile = \FilesModel::findByUuid($file);
						$objFile = new \File($objFile->path, true);

						$arrFiles[] = (object) array
						(
							'name'      => $objFile->name,
							'url'       => \Environment::get('request') . "?downloadId=" . $objDownload->id . "&fileIndex=" . $index,
							'index'     => $index++,
							'filesize'  => $this->getReadableSize($objFile->filesize, 1),
							'icon'      => \Image::getPath($objFile->icon),
							'mime'      => $objFile->mime,
							'extension' => $objFile->extension,
							'path'      => $objFile->dirname
						);
					}
				}

				$objDownload->fileSRC = $arrFiles;
				$objDownload->url = \Environment::get('request') . "?downloadId=" . $objDownload->id;
				$objDownload->hasAccess = $this->hasAccess($objDownload);
				$arrDownloads[] = $objDownload;
			}
		}

		if(count($arrDownloads))
		{
			$arrDownloads[0]->css .= ' first';
			$arrDownloads[count($arrDownloads) - 1]->css .= ' last';

			foreach($arrDownloads as $element)
			{
				$objTemplate = new \FrontendTemplate($this->category_template);
				$objTemplate->setData(((array) $element));
				$html .= $objTemplate->parse();
			}
		}

		$this->Template->html = $html;
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
