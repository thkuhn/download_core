<?php

namespace CDK\Frontend;
use CDK\Models, CDK\Classes;

class ModuleDownloadCategory extends \ModuleDownload
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
		if(\Input::get('downloadId') && FE_USER_LOGGED_IN)
		{
			$this->sendDownloadToBrowser(\Input::get('downloadId'));
		}

		$objPage = \PageModel::findById($GLOBALS['objPage']->id);
		$strUrl = \Controller::generateFrontendUrl($objPage->row(), '/element/%s');

		if(\Input::get('category'))
		{
			$objCategory = \DownloadCategoryModel::findByAlias(\Input::get('category'));
			$objArchiv   = \DownloadArchivModel::findById($objCategory->pid);
		}

		$arrDownloads = array();
		$objDownloads = \DownloadItemModel::findByPid($objCategory->id);

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
				foreach(deserialize($objDownload->fileSRC) as $file)
				{
					$arrFiles[] = \FilesModel::findByUuid($file);
				}

				$objDownload->fileSRC = $arrFiles;
				$objDownload->url = \Environment::get('request') . "?downloadId=" . $objDownload->id;
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
}
