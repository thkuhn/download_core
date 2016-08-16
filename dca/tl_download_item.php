<?php

$GLOBALS['TL_DCA']['tl_download_item'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_download_category',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_news_archive']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_mev_books_elements']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mev_books_elements']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mev_books_elements']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array('type', 'addImage', 'protected', 'published'),
		'default'                     => '{title_legend},title,type,teaser,text;{protected_legend},protected;{image_legend},addImage;{download_legend},fileSRC;{published_legend},published',
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
			'search'                  => true,
			'options'                 => array('single', 'multi', 'zipper'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_download_item']['type_option'],
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'teaser' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['teaser'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false),
			'sql'                     => "text NOT NULL" 
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['text'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false),
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
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'orderSRC', 'files'=>true, 'mandatory'=>true),
			'sql'                     => "blob NULL",
			'load_callback' => array
			(
				array('tl_download_item', 'setMultiSrcFlags')
			)
		),
		'orderSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['orderSRC'],
			'sql'                     => "blob NULL"
		),
		'fileSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_download_item']['fileSRC'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'fieldType'=>'checkbox', 'files'=>true, 'filesOnly'=>true),
			'sql'                     => "blob NULL"
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
	}

	public function listItems($arrRow) 
	{
		return $arrRow['title'];
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