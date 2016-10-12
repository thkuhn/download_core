<?php

namespace CDK\Frontend;
use CDK\Models;

class ModuleDownloadNavigation extends \Module
{
	protected $strTemplate = 'mod_download_navigation';
	private $trail = array();
	private $items = array();

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['download_navigation'][0]) . ' ###';
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

		$this->generateTrail(\Input::get('category'));

		$pid = 0;

		if($this->download_levelOffset != 0)
		{
			$pid = $this->trail[$this->download_levelOffset - 1];
		}
		elseif(\Input::get('category'))
		{
			$pid = \DownloadStructureModel::findByAlias(\Input::get('category'))->id;
		}
		elseif($this->download_referenceCategory)
		{
			$pid = $this->download_referenceCategory;
		}


		$this->items = $this->getCategory($pid, $this->download_levelOffset, 0, $this->download_hardlimit);

		if(!is_array($this->items))
		{
			return '';
		}

		return parent::generate();
	}

	protected function compile()
	{
		if(is_array($this->items))
		{
			$this->Template->html = $this->renderCategory($this->items);
		}
	}

	public function getCategory($pid, $offset, $level, $hardlimit = false)
	{
#		$objData = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE pid=? && published=? && hide=? && ((start = '' && stop = '') OR (start = '' && stop > ?) OR (start < ? && stop > ?))")->execute($pid, 1, '', time(), time(), time());
		$objData = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE pid=? && published=? && ((start = '' && stop = '') OR (start = '' && stop > ?) OR (start < ? && stop > ?)) ORDER BY sorting ASC")->execute($pid, 1, time(), time(), time());
		while($objData->next())
		{
			if(($objData->protected && $this->checkPermission(deserialize($objData->groups))) OR !$objData->protected)
			{
				if((!FE_USER_LOGGED_IN && $objData->guests) OR !$objData->guests)
				{
					$blnSubmenu = false;
					if($this->showTrail($level, $objData->row()))
					{
						$subitems = $this->getCategory($objData->id, $offset, ($level + 1), $hardlimit);

						if(is_array($subitems) && count($subitems))
						{
							$blnSubmenu = true;
						}
					}
					else
					{
						$subitems = $this->getCategory($objData->id, $offset, ($level + 1), $hardlimit);

						if(is_array($subitems) && count($subitems))
						{
							$blnSubmenu = true;
						}

						unset($subitems);
					}

					$objCount = $this->Database->prepare("SELECT * FROM tl_download_item WHERE pid=? && published=1 ORDER BY sorting ASC")->execute($objData->id);

					$item = $objData->row();
					$item['level']    = $level;
					$item['subitems'] = $subitems;
					$item['count']    = $objCount->count();

					if($blnSubmenu)
					{
						$item['cssClass'] = trim($item['cssClass'] . ' hasSubmenu');
						$item['hasSubmenu'] = true;
					}

					if($objCount->count())
					{
						$item['cssClass'] = trim($item['cssClass'] . ' hasDownloads');
						$item['hasDownloads'] = true;
						$item['numberOfDownloads'] = $objCount->count();
					}

					if($item['singleSRC'])
					{
						$item['archivIcon'] = \FilesModel::findByUuid($item['singleSRC'])->path;
					}

					$items[] = $item;
				}
			}
		}

		return $items;
	}

	public function renderCategory($items = array(), $level = 1)
	{
//		$objPage = \PageModel::findById($this->download_jumpTo);
		$objPage = \PageModel::findById($GLOBALS['objPage']->id);
		$strUrl  = \Controller::generateFrontendUrl($objPage->row(), '/category/%s');

		if(count($items) > 1)
		{
			$items[0]['css'] .= 'first ';
			$items[count($items) - 1]['css'] .= 'last ';
		}
		else
		{
			$items[0]['css'] .= 'only ';
		}

		foreach($items as $item)
		{
			$item = (object) $item;

			if($item->subitems)
			{
				$item->subitems = $this->renderCategory($item->subitems, $level + 1);
				$item->css .= 'submenu ';
			}

			if($this->trail[$level - 1] == $item->id)
			{
				if($this->trail[$level - 1] == end($this->trail))
				{
					$item->css .= 'active ';
				}
				else
				{
					$item->css .= 'trail ';
				}
			}

			switch($item->type)
			{
				case "regular":
					$pageId  = $this->download_jumpTo;
					$pageAdd = '/category/' . $item->alias;
					break;
				case "redirect":
					$objRedirect = \DownloadStructureModel::findById($item->categoryJump);

					$pageId = $this->download_jumpTo;
					$pageAdd = '/category/'. $objRedirect->alias;
					break;
				case "page":
					$pageId  = $item->jumpTo;
					$pageAdd = '';
					break;
				default:

					if (isset($GLOBALS['TL_HOOKS']['modifyOwnCategoryTyp']) && is_array($GLOBALS['TL_HOOKS']['modifyOwnCategoryTyp']))
					{
						foreach ($GLOBALS['TL_HOOKS']['modifyOwnCategoryTyp'] as $callback)
						{
							$this->import($callback[0]);
							$item = $this->$callback[0]->$callback[1]($item);
						}
					}

					$blnHook = true;

					break;
			}

			if(!$blnHook && $pageId)
			{
				$objPage = \PageModel::findById($pageId);
				$item->href = \Controller::generateFrontendUrl($objPage->row(), $pageAdd);
			}

			if(!$blnHook)
			{
				$objPage = \PageModel::findById($GLOBALS['objPage']->id);

				if($this->download_category_jumpTo)
				{
					$objPage = \PageModel::findById($this->download_category_jumpTo);
				}

				$item->more = \Controller::generateFrontendUrl($objPage->row(), $pageAdd);
			}

			if($item->href && $item->hasDownloads)
			{
				$item->url = $item->href;
			}
			elseif($item->more && $item->hasSubmenu)
			{
				$item->url = $item->more;
			}

			$item->css = trim(trim($item->css) . ' ' . trim($item->cssClass));
			$index[] = $item;
		}

		$dnTemplate = 'dn_node';
		if($this->download_node_template)
		{
			$dnTemplate = $this->download_node_template;
		}

		$objTemplate = new \FrontendTemplate($dnTemplate);
		$objTemplate->items = $index;
		$objTemplate->level = $level;

		return $objTemplate->parse();
	}

	public function generateTrail($IdOrAlias = '')
	{
		if(!$IdOrAlias)
		{
			return '';
		}

		$objCategory = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE alias=? or id=?")->execute($IdOrAlias, $IdOrAlias);

		if($objCategory->pid)
		{
			$this->generateTrail($objCategory->pid);
		}

		$this->trail[] = $objCategory->id;
	}

	public function checkPermission($groups)
	{
		$access = false;

		if(FE_USER_LOGGED_IN && is_array($groups))
		{
			foreach($groups as $group)
			{
				if(in_array($group, $this->Member->groups))
				{
					$access = true;
				}
			}
		}

		return $access;
	}

	public function showTrail($level, $item)
	{
		$show = false;

		if($this->download_showLevel == 0)
		{
			$show = true;
		}
		else
		{
			if(($this->download_showLevel - 1) > $level)
			{
				$show = true;
			}
			else
			{
				if(!$this->download_hardLimit && in_array($item['id'], $this->trail) && $this->trail[$level])
				{
					$show = true;
				}
			}
		}

		return $show;
	}
}
