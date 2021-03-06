<?php

$GLOBALS['TL_DCA']['tl_download_item'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_download_structure',
		'enableVersioning'            => false,
		'switchToEdit'                => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		),
		'onload_callback'             => array
			(
				array('tl_download_item', 'onloadCallback'),
			),
	),
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title'),
			'flag'                    => 11,
			'panelLayout'             => 'filter;search,limit',
			'disableGrouping'         => true,
			'child_record_callback'   => array('tl_download_item', 'listItems'),
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s <span style="color:#b3b3b3; padding-left:3px;">[]</span>'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_item']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_item']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_item']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_item']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_item']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_download_item', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_item']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array('type', 'addImage', 'protected', 'published'),
		'default'                     => '{title_legend},title,type,teaser,text;{protected_legend},protected;{image_legend},addImage;{published_legend},published',
		'single'                      => '{title_legend},title,type,teaser,text;{protected_legend},protected;{image_legend},addImage;{download_legend},fileSRC;{published_legend},published',
		'multi'                       => '{title_legend},title,type,teaser,text;{protected_legend},protected;{image_legend},addImage;{download_legend},fileSRC;{published_legend},published',
		'zipper'                      => '{title_legend},title,type,teaser,text;{protected_legend},protected;{image_legend},addImage;{download_legend},fileSRC;{published_legend},published',
		'external'                    => '{title_legend},title,type,teaser,text;{protected_legend},protected;{image_legend},addImage;{download_legend},fileURL;{published_legend},published',
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
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_download_structure.title',
			'sql'                     => "int(10) NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['title'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['type'],
			'inputType'               => 'select',
			'search'                  => false,
			'filter'                  => true,
			'options'                 => array('single', 'multi', 'zipper', 'external'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_download_item']['type_option'],
			'eval'                    => array('mandatory'=>true, 'includeBlankOption' => true, 'tl_class'=>'w50', 'submitOnChange'=>true),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'teaser' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['teaser'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'tl_class'=>'clr'),
			'sql'                     => "text NOT NULL"
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['text'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'tl_class'=>'clr'),
			'sql'                     => "text NOT NULL"
		),
		'protected' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['protected'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'groups' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['groups'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('multiple' => true, 'tl_class' => ''),
			'sql'                     => "blob NOT NULL"
		),
		'addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['addImage'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['singleSRC'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'files'=>true, 'mandatory'=>true),
			'sql'                     => "blob NULL",
			'load_callback' => array
			(
				array('tl_download_item', 'setMultiSrcFlags')
			)
		),
		'fileSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['fileSRC'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'orderSRC', 'files'=>true, 'filesOnly'=>true),
			'sql'                     => "blob NULL"
		),
		'orderSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['orderSRC'],
			'sql'                     => "blob NULL"
		),
		'fileURL' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['fileURL'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),

		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['published'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange' => true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);

class tl_download_item extends Backend
{
	public function __construct()
	{
		parent::__construct();

		$this->import('BackendUser', 'User');
	}

	public function listItems($arrRow)
	{
		return $arrRow['title'];
	}

	/**
	 * Check permissions to edit table tl_calendar_events
	 */
	// TODO: implement correct permissions checks
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		$id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

		// Check current action
		switch (Input::get('act'))
		{

			case 'paste':
			case 'toggle':

			default:
				// Allow
				break;
		}
	}


	public function onloadCallback($dc)
	{

		// Modify file select widget config depending on download item type
		if ($dc->id)
		{
			$objItem = \Database::getInstance()
				->prepare("SELECT * FROM tl_download_item WHERE id=?")
				->execute($dc->id);

			if ($objItem->type == 'single')
			{
				$GLOBALS['TL_DCA']['tl_download_item']['fields']['fileSRC']['eval']['multiple'] = false;
				$GLOBALS['TL_DCA']['tl_download_item']['fields']['fileSRC']['eval']['fieldType'] = 'radio';
			}
			elseif (in_array($objItem->type, array('multi', 'zipper')))
			{
				$GLOBALS['TL_DCA']['tl_download_item']['fields']['fileSRC']['eval']['multiple'] = true;
				$GLOBALS['TL_DCA']['tl_download_item']['fields']['fileSRC']['eval']['fieldType'] = 'checkbox';
			}
		}


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
		if (!$this->User->hasAccess('tl_download_item::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
	}


	/**
	 * Publish/unpublish a download item
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

		// $this->checkPermission();

		// Check the field access
		if (!$this->User->hasAccess('tl_download_item::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish download item ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_download_item', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_download_item']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_download_item']['fields']['published']['save_callback'] as $callback)
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
		$this->Database->prepare("UPDATE tl_download_item SET tstamp=". time() .", published = '" . ($blnVisible ? '1' : '') . "' WHERE id=?")
			->execute($intId);

		$objVersions->create();
	}

	public function setMultiSrcFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
			$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
			$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
		}

		return $varValue;
	}
}
