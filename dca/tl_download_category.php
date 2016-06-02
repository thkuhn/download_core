<?php

$GLOBALS['TL_DCA']['tl_download_category'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_download_item'),
		'ptable'                      => 'tl_download_archiv',
		'enableVersioning'            => false,
		'switchToEdit'                => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
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
			'child_record_callback'   => array('tl_download_category', 'listItems'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_download_category']['edit'],
				'href'                => 'table=tl_download_item',
				'icon'                => 'edit.gif',
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_category']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
			),
#			'copy' => array
#			(
#				'label'               => &$GLOBALS['TL_LANG']['tl_content']['copy'],
#				'href'                => 'act=paste&amp;mode=copy',
#				'icon'                => 'copy.gif',
#				'attributes'          => 'onclick="Backend.getScrollOffset()"'
#			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_category']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_category']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_download_category']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array('addImage', 'published'),
		'default'                     => '{title_legend},title,alias;{image_legend},addImage;{published_legend},published',
	),
	'subpalettes' => array
	(
		'addImage'                    => 'singleSRC',
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
			'sql'                     => "int(10) NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                       => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['title'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''" 
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['alias'],
			'exclude'                 => true,
			'search'                  => false,
			'filter'                  => false,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                     => "varchar(128) NOT NULL default ''",
			'save_callback' => array
			(
				array('tl_download_category', 'generateAlias')
			)
		),
		'addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['addImage'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['singleSRC'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>true,'fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true,'extensions'=>'jpg,png,gif'),
			'sql'                     => "binary(16) NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['published'],
			'default'                 => '',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange' => true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_category']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);

class tl_download_category extends Backend 
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function listItems($arrRow) 
	{
		return $arrRow['title'];
	}

	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}

#        $objAlias = $this->Database->prepare("SELECT id FROM tl_docs_titles WHERE id=? OR alias=?")
#                                   ->execute($dc->id, $varValue);

		return $varValue;
	}
}