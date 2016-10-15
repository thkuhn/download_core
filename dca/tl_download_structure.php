<?php

$GLOBALS['TL_DCA']['tl_download_structure'] = array
(
	'config' => array
	(
		'label'                       => 'Download-Archiv',
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_download_item'),
		'enableVersioning'            => true,
		'onload_callback' => array
		(
//			array('tl_download_structure', 'checkPermission'),
//			array('tl_download_structure', 'addBreadcrumb'),
//			array('tl_download_structure', 'setRootType'),
//			array('tl_download_structure', 'showFallbackWarning')
		),
		'onsubmit_callback' => array
		(
//			array('tl_download_structure', 'updateSitemap'),
//			array('tl_download_structure', 'generateArticle')
		),
		'ondelete_callback' => array
		(
//			array('tl_download_structure', 'purgeSearchIndex')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'alias' => 'index',
				'pid,type,start,stop,published' => 'index'
			)
		)
	),
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 5,
			'icon'                    => 'pagemounts.gif',
			'paste_button_callback'   => array('tl_download_structure', 'pastePage'),
			'panelLayout'             => 'filter,search'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s',
			'label_callback'          => array('tl_download_structure', 'addIcon')
		),
		'global_operations' => array
		(
			'toggleNodes' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['toggleAll'],
				'href'                => 'ptg=all',
				'class'               => 'header_toggle',
				'showOnSelect'        => true
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'downloads' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['downloads'],
				'href'                => 'table=tl_download_item',
				'icon'                => 'edit.gif',
//				'button_callback'     => array('tl_download_structure', 'editArticles')
			),
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_download_structure', 'editPage')
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"',
				'button_callback'     => array('tl_download_structure', 'copyPage')
			),
			'copyChilds' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['copyChilds'],
				'href'                => 'act=paste&amp;mode=copy&amp;childs=1',
				'icon'                => 'copychilds.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"',
				'button_callback'     => array('tl_download_structure', 'copyPageWithSubpages')
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"',
				'button_callback'     => array('tl_download_structure', 'cutPage')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_download_structure', 'deletePage')
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_download_structure', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_structure']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		)
	),
	'select' => array
	(
		'buttons_callback' => array
		(
			array('tl_download_structure', 'addAliasButton')
		)
	),
	'palettes' => array
	(
		'__selector__'                => array('type', 'addImage', 'protected', 'published'),
		'default'                     => '{title_legend},title,type,alias,cssClass',
		'regular'                     => '{title_legend},title,type,alias,cssClass,teaser,text;{image_legend},addImage;{protected_legend},protected;{published_legend},published',
		'redirect'                    => '{title_legend},title,type,alias,cssClass,teaser,text;{image_legend},addImage;{protected_legend},protected;{redirect_legend},redirectURL;{published_legend},published',
	),
	'subpalettes' => array
	(
		'addImage'                    => 'singleSRC',
		'protected'                   => 'groups',
		'published'                   => 'start,stop'
	),
	'fields' => array
	(
		'id' => array
		(
			'label'                   => array('ID'),
			'search'                  => true,
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('rgxp'=>'folderalias', 'doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_download_structure', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['type'],
			'default'                 => 'regular',
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('regular', 'redirect'),
			'eval'                    => array('helpwizard'=>false, 'mandatory' => true, 'includeBlankOption' => true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_download_structure']['type_option'],
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'teaser' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['teaser'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'tl_class'=>'clr'),
			'sql'                     => "text NOT NULL"
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['text'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'tl_class'=>'clr'),
			'sql'                     => "text NOT NULL"
		),
		'cssClass' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['cssClass'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'protected' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['protected'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'groups' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['groups'],
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('multiple'=>true, 'mandatory'=>false, 'tl_class'=>'clr'),
			'sql'                     => "text NOT NULL"
		),
		'addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['addImage'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['singleSRC'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>true,'fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true,'extensions'=>'jpg,png,gif'),
			'sql'                     => "binary(16) NULL"
		),
		'redirectURL' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['redirectURL'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),

		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['published'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_structure']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);

// Disable certain operations in the modal dialog
if (Input::get('popup'))
{
	unset($GLOBALS['TL_DCA']['tl_download_structure']['list']['operations']['show']);
	unset($GLOBALS['TL_DCA']['tl_download_structure']['list']['operations']['articles']);
}


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_download_structure extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Check permissions to edit table tl_download_structure
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		$session = $this->Session->getData();

		// Set the default page user and group
		$GLOBALS['TL_DCA']['tl_download_structure']['fields']['cuser']['default'] = intval(Config::get('defaultUser') ?: $this->User->id);
		$GLOBALS['TL_DCA']['tl_download_structure']['fields']['cgroup']['default'] = intval(Config::get('defaultGroup') ?: $this->User->groups[0]);

		// Restrict the page tree
		$GLOBALS['TL_DCA']['tl_download_structure']['list']['sorting']['root'] = $this->User->pagemounts;

		// Set allowed page IDs (edit multiple)
		if (is_array($session['CURRENT']['IDS']))
		{
			$edit_all = array();
			$delete_all = array();

			foreach ($session['CURRENT']['IDS'] as $id)
			{
				$objPage = $this->Database->prepare("SELECT id, pid, type, includeChmod, chmod, cuser, cgroup FROM tl_download_structure WHERE id=?")
										  ->limit(1)
										  ->execute($id);

				if ($objPage->numRows < 1 || !$this->User->hasAccess($objPage->type, 'alpty'))
				{
					continue;
				}

				$row = $objPage->row();

				if ($this->User->isAllowed(BackendUser::CAN_EDIT_PAGE, $row))
				{
					$edit_all[] = $id;
				}

				// Mounted pages cannot be deleted
				if ($this->User->isAllowed(BackendUser::CAN_DELETE_PAGE, $row) && !$this->User->hasAccess($id, 'pagemounts'))
				{
					$delete_all[] = $id;
				}
			}

			$session['CURRENT']['IDS'] = (Input::get('act') == 'deleteAll') ? $delete_all : $edit_all;
		}

		// Set allowed clipboard IDs
		if (isset($session['CLIPBOARD']['tl_download_structure']) && is_array($session['CLIPBOARD']['tl_download_structure']['id']))
		{
			$clipboard = array();

			foreach ($session['CLIPBOARD']['tl_download_structure']['id'] as $id)
			{
				$objPage = $this->Database->prepare("SELECT id, pid, type, includeChmod, chmod, cuser, cgroup FROM tl_download_structure WHERE id=?")
										  ->limit(1)
										  ->execute($id);

				if ($objPage->numRows < 1 || !$this->User->hasAccess($objPage->type, 'alpty'))
				{
					continue;
				}

				if ($this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $objPage->row()))
				{
					$clipboard[] = $id;
				}
			}

			$session['CLIPBOARD']['tl_download_structure']['id'] = $clipboard;
		}

		// Overwrite session
		$this->Session->setData($session);

		// Check permissions to save and create new
		if (Input::get('act') == 'edit')
		{
			$objPage = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE id=(SELECT pid FROM tl_download_structure WHERE id=?)")
									  ->limit(1)
									  ->execute(Input::get('id'));

			if ($objPage->numRows && !$this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $objPage->row()))
			{
				$GLOBALS['TL_DCA']['tl_download_structure']['config']['closed'] = true;
			}
		}

		// Check current action
		if (Input::get('act') && Input::get('act') != 'paste')
		{
			$permission = 0;
			$cid = CURRENT_ID ?: Input::get('id');
			$ids = ($cid != '') ? array($cid) : array();

			// Set permission
			switch (Input::get('act'))
			{
				case 'edit':
				case 'toggle':
					$permission = BackendUser::CAN_EDIT_PAGE;
					break;

				case 'move':
					$permission = BackendUser::CAN_EDIT_PAGE_HIERARCHY;
					$ids[] = Input::get('sid');
					break;

				case 'create':
				case 'copy':
				case 'copyAll':
				case 'cut':
				case 'cutAll':
					$permission = BackendUser::CAN_EDIT_PAGE_HIERARCHY;

					// Check the parent page in "paste into" mode
					if (Input::get('mode') == 2)
					{
						$ids[] = Input::get('pid');
					}
					// Check the parent's parent page in "paste after" mode
					else
					{
						$objPage = $this->Database->prepare("SELECT pid FROM tl_download_structure WHERE id=?")
												  ->limit(1)
												  ->execute(Input::get('pid'));

						$ids[] = $objPage->pid;
					}
					break;

				case 'delete':
					$permission = BackendUser::CAN_DELETE_PAGE;
					break;
			}

			// Check user permissions
			if (Input::get('act') != 'show')
			{
				$pagemounts = array();

				// Get all allowed pages for the current user
				foreach ($this->User->pagemounts as $root)
				{
					if (Input::get('act') != 'delete')
					{
						$pagemounts[] = $root;
					}

					$pagemounts = array_merge($pagemounts, $this->Database->getChildRecords($root, 'tl_download_structure'));
				}

				$error = false;
				$pagemounts = array_unique($pagemounts);

				// Do not allow to paste after pages on the root level (pagemounts)
				if ((Input::get('act') == 'cut' || Input::get('act') == 'cutAll') && Input::get('mode') == 1 && in_array(Input::get('pid'), $this->eliminateNestedPages($this->User->pagemounts)))
				{
					$this->log('Not enough permissions to paste page ID '. Input::get('id') .' after mounted page ID '. Input::get('pid') .' (root level)', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				// Check each page
				foreach ($ids as $i=>$id)
				{
					if (!in_array($id, $pagemounts))
					{
						$this->log('Page ID '. $id .' was not mounted', __METHOD__, TL_ERROR);

						$error = true;
						break;
					}

					// Get the page object
					$objPage = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE id=?")
											  ->limit(1)
											  ->execute($id);

					if ($objPage->numRows < 1)
					{
						continue;
					}

					// Check whether the current user is allowed to access the current page
					if (!$this->User->isAllowed($permission, $objPage->row()))
					{
						$error = true;
						break;
					}

					// Check the type of the first page (not the following parent pages)
					// In "edit multiple" mode, $ids contains only the parent ID, therefore check $id != $_GET['pid'] (see #5620)
					if ($i == 0 && $id != Input::get('pid') && Input::get('act') != 'create' && !$this->User->hasAccess($objPage->type, 'alpty'))
					{
						$this->log('Not enough permissions to  '. Input::get('act') .' '. $objPage->type .' pages', __METHOD__, TL_ERROR);

						$error = true;
						break;
					}
				}

				// Redirect if there is an error
				if ($error)
				{
					$this->log('Not enough permissions to '. Input::get('act') .' page ID '. $cid .' or paste after/into page ID '. Input::get('pid'), __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			}
		}
	}


	/**
	 * Add the breadcrumb menu
	 */
	public function addBreadcrumb()
	{
		Backend::addPagesBreadcrumb();
	}


	/**
	 * Make new top-level pages root pages
	 *
	 * @param DataContainer $dc
	 */
	public function setRootType(DataContainer $dc)
	{
		if (Input::get('act') != 'create')
		{
			return;
		}

		// Insert into
		if (Input::get('pid') == 0)
		{
			$GLOBALS['TL_DCA']['tl_download_structure']['fields']['type']['default'] = 'root';
		}
		elseif (Input::get('mode') == 1)
		{
			$objPage = $this->Database->prepare("SELECT * FROM " . $dc->table . " WHERE id=?")
									  ->limit(1)
									  ->execute(Input::get('pid'));

			if ($objPage->pid == 0)
			{
				$GLOBALS['TL_DCA']['tl_download_structure']['fields']['type']['default'] = 'root';
			}
		}
	}


	/**
	 * Make sure that top-level pages are root pages
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public function checkRootType($varValue, DataContainer $dc)
	{
		if ($varValue != 'root' && $dc->activeRecord->pid == 0)
		{
			throw new Exception($GLOBALS['TL_LANG']['ERR']['topLevelRoot']);
		}

		return $varValue;
	}


	/**
	 * Show a warning if there is no language fallback page
	 */
	public function showFallbackWarning()
	{
		if (Input::get('act') != '')
		{
			return;
		}

		$this->import('Messages');
		Message::addRaw($this->Messages->languageFallback());
		Message::addRaw($this->Messages->topLevelRoot());
	}


	/**
	 * Auto-generate a page alias if it has not been set yet
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return string
	 *
	 * @throws Exception
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate an alias if there is none
		if ($varValue == '')
		{
			$autoAlias = true;
			$varValue = StringUtil::generateAlias($dc->activeRecord->title);

			// Generate folder URL aliases (see #4933)
			if (Config::get('folderUrl'))
			{
				$objPage = PageModel::findWithDetails($dc->activeRecord->id);

				if ($objPage->folderUrl != '')
				{
					$varValue = $objPage->folderUrl . $varValue;
				}
			}
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_download_structure WHERE id=? OR alias=?")
								   ->execute($dc->id, $varValue);

		// Check whether the page alias exists
		if ($objAlias->numRows > ($autoAlias ? 0 : 1))
		{
			$arrPages = array();
			$strDomain = '';
			$strLanguage = '';

			while ($objAlias->next())
			{
				$objCurrentPage = PageModel::findWithDetails($objAlias->id);
				$domain = $objCurrentPage->domain ?: '*';
				$language = (!$objCurrentPage->rootIsFallback) ? $objCurrentPage->rootLanguage : '*';

				// Store the current page's data
				if ($objCurrentPage->id == $dc->id)
				{
					// Get the DNS and language settings from the POST data (see #4610)
					if ($objCurrentPage->type == 'root')
					{
						$strDomain = Input::post('dns');
						$strLanguage = Input::post('language');
					}
					else
					{
						$strDomain = $domain;
						$strLanguage = $language;
					}
				}
				else
				{
					// Check the domain and language or the domain only
					if (Config::get('addLanguageToUrl'))
					{
						$arrPages[$domain][$language][] = $objAlias->id;
					}
					else
					{
						$arrPages[$domain][] = $objAlias->id;
					}
				}
			}

			$arrCheck = Config::get('addLanguageToUrl') ? $arrPages[$strDomain][$strLanguage] : $arrPages[$strDomain];

			// Check if there are multiple results for the current domain
			if (!empty($arrCheck))
			{
				if ($autoAlias)
				{
					$varValue .= '-' . $dc->id;
				}
				else
				{
					throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
				}
			}
		}

		return $varValue;
	}


	/**
	 * Automatically create an article in the main column of a new page
	 *
	 * @param DataContainer $dc
	 */
	public function generateArticle(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		// Existing or not a regular page
		if ($dc->activeRecord->tstamp > 0 || !in_array($dc->activeRecord->type, array('regular', 'error_403', 'error_404')))
		{
			return;
		}

		$new_records = $this->Session->get('new_records');

		// Not a new page
		if (!$new_records || (is_array($new_records[$dc->table]) && !in_array($dc->id, $new_records[$dc->table])))
		{
			return;
		}

		// Check whether there are articles (e.g. on copied pages)
		$objTotal = $this->Database->prepare("SELECT COUNT(*) AS count FROM tl_article WHERE pid=?")
								   ->execute($dc->id);

		if ($objTotal->count > 0)
		{
			return;
		}

		// Create article
		$arrSet['pid'] = $dc->id;
		$arrSet['sorting'] = 128;
		$arrSet['tstamp'] = time();
		$arrSet['author'] = $this->User->id;
		$arrSet['inColumn'] = 'main';
		$arrSet['title'] = $dc->activeRecord->title;
		$arrSet['alias'] = str_replace('/', '-', $dc->activeRecord->alias); // see #5168
		$arrSet['published'] = $dc->activeRecord->published;

		$this->Database->prepare("INSERT INTO tl_article %s")->set($arrSet)->execute();
	}


	/**
	 * Purge the search index if a page is being deleted
	 *
	 * @param DataContainer $dc
	 */
	public function purgeSearchIndex(DataContainer $dc)
	{
		if (!$dc->id)
		{
			return;
		}

		$objResult = $this->Database->prepare("SELECT id FROM tl_search WHERE pid=?")
									->execute($dc->id);

		while ($objResult->next())
		{
			$this->Database->prepare("DELETE FROM tl_search WHERE id=?")
						   ->execute($objResult->id);

			$this->Database->prepare("DELETE FROM tl_search_index WHERE pid=?")
						   ->execute($objResult->id);
		}
	}


	/**
	 * Check the sitemap alias
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public function checkFeedAlias($varValue, DataContainer $dc)
	{
		// No change or empty value
		if ($varValue == $dc->value || $varValue == '')
		{
			return $varValue;
		}

		$varValue = standardize($varValue); // see #5096

		$this->import('Automator');
		$arrFeeds = $this->Automator->purgeXmlFiles(true);

		// Alias exists
		if (array_search($varValue, $arrFeeds) !== false)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		return $varValue;
	}


	/**
	 * Prevent circular references
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public function checkJumpTo($varValue, DataContainer $dc)
	{
		if ($varValue == $dc->id)
		{
			throw new Exception($GLOBALS['TL_LANG']['ERR']['circularReference']);
		}

		return $varValue;
	}


	/**
	 * Check the DNS settings
	 *
	 * @param mixed $varValue
	 *
	 * @return mixed
	 */
	public function checkDns($varValue)
	{
		return str_ireplace(array('http://', 'https://', 'ftp://'), '', $varValue);
	}


	/**
	 * Make sure there is only one fallback per domain (thanks to Andreas Schempp)
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public function checkFallback($varValue, DataContainer $dc)
	{
		if ($varValue == '')
		{
			return '';
		}

		$objPage = $this->Database->prepare("SELECT id FROM tl_download_structure WHERE type='root' AND fallback=1 AND dns=? AND id!=?")
								  ->execute($dc->activeRecord->dns, $dc->activeRecord->id);

		if ($objPage->numRows)
		{
			throw new Exception($GLOBALS['TL_LANG']['ERR']['multipleFallback']);
		}

		return $varValue;
	}


	/**
	 * Check a static URL
	 *
	 * @param mixed $varValue
	 *
	 * @return mixed
	 */
	public function checkStaticUrl($varValue)
	{
		if ($varValue != '')
		{
			$varValue = preg_replace('@https?://@', '', $varValue);
		}

		return $varValue;
	}


	/**
	 * Returns all allowed page types as array
	 *
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function getPageTypes(DataContainer $dc)
	{
		$arrOptions = array();

		foreach (array_keys($GLOBALS['TL_PTY']) as $pty)
		{
			// Root pages are allowed on the first level only (see #6360)
			if ($pty == 'root' && $dc->activeRecord && $dc->activeRecord->pid > 0)
			{
				continue;
			}

			// Allow the currently selected option and anything the user has access to
			if ($pty == $dc->value || $this->User->hasAccess($pty, 'alpty'))
			{
				$arrOptions[] = $pty;
			}
		}

		return $arrOptions;
	}


	/**
	 * Return all page layouts grouped by theme
	 *
	 * @return array
	 */
	public function getPageLayouts()
	{
		$objLayout = $this->Database->execute("SELECT l.id, l.name, t.name AS theme FROM tl_layout l LEFT JOIN tl_theme t ON l.pid=t.id ORDER BY t.name, l.name");

		if ($objLayout->numRows < 1)
		{
			return array();
		}

		$return = array();

		while ($objLayout->next())
		{
			$return[$objLayout->theme][$objLayout->id] = $objLayout->name;
		}

		return $return;
	}


	/**
	 * Add an image to each page in the tree
	 *
	 * @param array         $row
	 * @param string        $label
	 * @param DataContainer $dc
	 * @param string        $imageAttribute
	 * @param boolean       $blnReturnImage
	 * @param boolean       $blnProtected
	 *
	 * @return string
	 */
	public function addIcon($row, $label, DataContainer $dc=null, $imageAttribute='', $blnReturnImage=false, $blnProtected=false)
	{
		return Backend::addPageIcon($row, $label, $dc, $imageAttribute, $blnReturnImage, $blnProtected);
	}


	/**
	 * Return the edit page button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function editPage($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_EDIT_PAGE, $row)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the copy page button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 * @param string $table
	 *
	 * @return string
	 */
	public function copyPage($row, $href, $label, $title, $icon, $attributes, $table)
	{
		if ($GLOBALS['TL_DCA'][$table]['config']['closed'])
		{
			return '';
		}

		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $row)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the copy page with subpages button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 * @param string $table
	 *
	 * @return string
	 */
	public function copyPageWithSubpages($row, $href, $label, $title, $icon, $attributes, $table)
	{
		if ($GLOBALS['TL_DCA'][$table]['config']['closed'])
		{
			return '';
		}

		$objSubpages = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE pid=?")
									  ->limit(1)
									  ->execute($row['id']);

		return ($objSubpages->numRows && $this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $row)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the cut page button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function cutPage($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $row)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the paste page button
	 *
	 * @param DataContainer $dc
	 * @param array         $row
	 * @param string        $table
	 * @param boolean       $cr
	 * @param array         $arrClipboard
	 *
	 * @return string
	 */
	public function pastePage(DataContainer $dc, $row, $table, $cr, $arrClipboard=null)
	{
		$disablePA = false;
		$disablePI = false;

		// Disable all buttons if there is a circular reference
		if ($arrClipboard !== false && ($arrClipboard['mode'] == 'cut' && ($cr == 1 || $arrClipboard['id'] == $row['id']) || $arrClipboard['mode'] == 'cutAll' && ($cr == 1 || in_array($row['id'], $arrClipboard['id']))))
		{
			$disablePA = true;
			$disablePI = true;
		}

		// Prevent adding non-root pages on top-level
		if (Input::get('mode') != 'create' && $row['pid'] == 0)
		{
			$objPage = $this->Database->prepare("SELECT * FROM " . $table . " WHERE id=?")
									  ->limit(1)
									  ->execute(Input::get('id'));

			if ($objPage->type != 'root')
			{
				$disablePA = true;

				if ($row['id'] == 0)
				{
					$disablePI = true;
				}
			}
		}

		// Check permissions if the user is not an administrator
		if (!$this->User->isAdmin)
		{
			// Disable "paste into" button if there is no permission 2 (move) or 1 (create) for the current page
			if (!$disablePI)
			{
				if (!$this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $row) || (Input::get('mode') == 'create' && !$this->User->isAllowed(BackendUser::CAN_EDIT_PAGE, $row)))
				{
					$disablePI = true;
				}
			}

			$objPage = $this->Database->prepare("SELECT * FROM " . $table . " WHERE id=?")
									  ->limit(1)
									  ->execute($row['pid']);

			// Disable "paste after" button if there is no permission 2 (move) or 1 (create) for the parent page
			if (!$disablePA && $objPage->numRows)
			{
				if (!$this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $objPage->row()) || (Input::get('mode') == 'create' && !$this->User->isAllowed(BackendUser::CAN_EDIT_PAGE, $objPage->row())))
				{
					$disablePA = true;
				}
			}

			// Disable "paste after" button if the parent page is a root page and the user is not an administrator
			if (!$disablePA && ($row['pid'] < 1 || in_array($row['id'], $dc->rootIds)))
			{
				$disablePA = true;
			}
		}

		$return = '';

		// Return the buttons
		$imagePasteAfter = Image::getHtml('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id']));
		$imagePasteInto = Image::getHtml('pasteinto.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteinto'][1], $row['id']));

		if ($row['id'] > 0)
		{
			$return = $disablePA ? Image::getHtml('pasteafter_.gif').' ' : '<a href="'.$this->addToUrl('act='.$arrClipboard['mode'].'&amp;mode=1&amp;pid='.$row['id'].(!is_array($arrClipboard['id']) ? '&amp;id='.$arrClipboard['id'] : '')).'" title="'.specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id'])).'" onclick="Backend.getScrollOffset()">'.$imagePasteAfter.'</a> ';
		}

		return $return.($disablePI ? Image::getHtml('pasteinto_.gif').' ' : '<a href="'.$this->addToUrl('act='.$arrClipboard['mode'].'&amp;mode=2&amp;pid='.$row['id'].(!is_array($arrClipboard['id']) ? '&amp;id='.$arrClipboard['id'] : '')).'" title="'.specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteinto'][1], $row['id'])).'" onclick="Backend.getScrollOffset()">'.$imagePasteInto.'</a> ');
	}


	/**
	 * Return the delete page button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function deletePage($row, $href, $label, $title, $icon, $attributes)
	{
		$root = func_get_arg(7);

		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_DELETE_PAGE, $row) && ($this->User->isAdmin || !in_array($row['id'], $root))) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Generate an "edit articles" button and return it as string
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 *
	 * @return string
	 */
	public function editArticles($row, $href, $label, $title, $icon)
	{
		if (!$this->User->hasAccess('article', 'modules'))
		{
			return '';
		}

		return ($row['type'] == 'regular' || $row['type'] == 'error_403' || $row['type'] == 'error_404') ? '<a href="' . $this->addToUrl($href.'&amp;node='.$row['id']) . '" title="'.specialchars($title).'">'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Automatically generate the folder URL aliases
	 *
	 * @param array         $arrButtons
	 * @param DataContainer $dc
	 *
	 * @return array
	 */
	public function addAliasButton($arrButtons, DataContainer $dc)
	{
		// Generate the aliases
		if (Input::post('FORM_SUBMIT') == 'tl_select' && isset($_POST['alias']))
		{
			$session = $this->Session->getData();
			$ids = $session['CURRENT']['IDS'];

			foreach ($ids as $id)
			{
				$objPage = PageModel::findWithDetails($id);

				if ($objPage === null)
				{
					continue;
				}

				$dc->id = $id;
				$dc->activeRecord = $objPage;

				$strAlias = '';

				// Generate new alias through save callbacks
				foreach ($GLOBALS['TL_DCA'][$dc->table]['fields']['alias']['save_callback'] as $callback)
				{
					if (is_array($callback))
					{
						$this->import($callback[0]);
						$strAlias = $this->{$callback[0]}->{$callback[1]}($strAlias, $dc);
					}
					elseif (is_callable($callback))
					{
						$strAlias = $callback($strAlias, $dc);
					}
				}

				// The alias has not changed
				if ($strAlias == $objPage->alias)
				{
					continue;
				}

				// Initialize the version manager
				$objVersions = new Versions('tl_download_structure', $id);
				$objVersions->initialize();

				// Store the new alias
				$this->Database->prepare("UPDATE tl_download_structure SET alias=? WHERE id=?")
							   ->execute($strAlias, $id);

				// Create a new version
				$objVersions->create();
			}

			$this->redirect($this->getReferer());
		}

		// Add the button
		$arrButtons['alias'] = '<input type="submit" name="alias" id="alias" class="tl_submit" accesskey="a" value="'.specialchars($GLOBALS['TL_LANG']['MSC']['aliasSelected']).'"> ';

		return $arrButtons;
	}


	/**
	 * Recursively add pages to a sitemap
	 *
	 * @param DataContainer $dc
	 */
	public function updateSitemap(DataContainer $dc)
	{
		$this->import('Automator');
		$this->Automator->generateSitemap($dc->id);
	}


	/**
	 * Return the "toggle visibility" button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->hasAccess('tl_download_structure::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		$objPage = $this->Database->prepare("SELECT * FROM tl_download_structure WHERE id=?")
								  ->limit(1)
								  ->execute($row['id']);

		if (!$this->User->hasAccess($row['type'], 'alpty') || !$this->User->isAllowed(BackendUser::CAN_EDIT_PAGE, $objPage->row()))
		{
			return Image::getHtml($icon) . ' ';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
	}


	/**
	 * Disable/enable a user group
	 *
	 * @param integer       $intId
	 * @param boolean       $blnVisible
	 * @param DataContainer $dc
	 */
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Set the ID and action
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

		if ($dc)
		{
			$dc->id = $intId; // see #8043
		}

		$this->checkPermission();

		// Check the field access
		if (!$this->User->hasAccess('tl_download_structure::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish page ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_download_structure', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_download_structure']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_download_structure']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_download_structure SET tstamp=". time() .", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
					   ->execute($intId);

		$objVersions->create();
		$this->log('A new version of record "tl_download_structure.id='.$intId.'" has been created'.$this->getParentEntries('tl_download_structure', $intId), __METHOD__, TL_GENERAL);
	}
}
