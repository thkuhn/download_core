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

		$strBuffer = '';

		if(\Input::get('category'))
		{
			$objCategory = \DownloadStructureModel::findByAlias(\Input::get('category'));
		}
		else
		{
			$this->Template->downloads = $strBuffer;
		}

		$this->Template->objCategory = $objCategory;
		$this->Template->category_headline = $objCategory->title;
		$this->Template->category_teaser = $objCategory->teaser;
		$this->Template->category_text = $objCategory->text;

		if ($objCategory->addImage)
		{
			$this->Template->category_image = \FilesModel::findByUuid($objCategory->singleSRC);
		}

		$strUrl = \Environment::get('request');

		$arrDownloads = array();
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

				switch ($objDownload->type)
				{
					case 'external':
						if (!empty($objDownload->fileURL))
						{

							$strExtension = substr($objDownload->fileURL, strrpos($objDownload->fileURL, '.'));
							$arrMime = array('application/octet-stream', 'iconPLAIN.gif');

							if (isset($GLOBALS['TL_MIME'][$strExtension]))
							{
								$arrMime = $GLOBALS['TL_MIME'][$strExtension];
							}

							$arrFiles[] = (object) array
							(
								'name'      => basename($objDownload->fileURL),
								'url'       => $objDownload->fileURL,
								'index'     => $index++,
								'filesize'  => null,
								'icon'      => \Image::getPath($arrMime[1]),
								'mime'      => $arrMime[0],
								'extension' => $strExtension,
								'path'      => null
							);
						}

						$objDownload->fileSRC = $arrFiles;
						$objDownload->url = $objDownload->fileURL;

						break;

					case 'single':
					case 'multi':
					case 'zipper':
					default:
						if(is_array(deserialize($objDownload->fileSRC)))
						{
							foreach(deserialize($objDownload->fileSRC) as $file)
							{
								$objFile = \FilesModel::findByUuid($file);
								$objFile = new \File($objFile->path, true);

								$arrFiles[] = (object) array
								(
									'name'      => $objFile->name,
									'url'       => $strUrl . "?downloadId=" . $objDownload->id . "&fileIndex=" . $index,
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
						$objDownload->url = $strUrl . "?downloadId=" . $objDownload->id;

						break;
				}


				$objDownload->hasAccess = $this->hasAccess($objDownload);
				$arrDownloads[] = $objDownload;
			}
		}

		if(!empty($arrDownloads))
		{
			$arrDownloads[0]->css .= ' first';
			$arrDownloads[count($arrDownloads) - 1]->css .= ' last';

			foreach($arrDownloads as $element)
			{
				$objTemplate = new \FrontendTemplate($this->category_template);
				$objTemplate->setData(((array) $element));
				$strBuffer .= $objTemplate->parse();
			}
		}

		$this->Template->downloads = $strBuffer;
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
