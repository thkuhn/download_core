<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][]      = 'download_reference';

$GLOBALS['TL_DCA']['tl_module']['palettes']['download_archiv']     = '{title_legend},name,headline,type;{config_legend},download_archiv,jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['download_category']   = '{title_legend},name,headline,type;{template_legend:hide},category_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['download_index']      = '{title_legend},name,headline,type;{config_legend},download_archiv,jumpTo;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['download_navigation'] = '{title_legend},name,headline,type;{nav_legend},download_levelOffset,download_showLevel,download_hardLimit;{list_legend},download_jumpTo,download_category_jumpTo;{reference_legend},download_reference;{template_legend:hide},customTpl,download_node_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['download_reference'] = 'download_referenceCategory';

$GLOBALS['TL_DCA']['tl_module']['fields']['download_jumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_jumpTo'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class' => 'clr'),
	'sql'                     => "int(10) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_category_jumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_jumpTo'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class' => 'clr'),
	'sql'                     => "int(10) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_levelOffset'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_levelOffset'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>true, 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_showLevel'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_showLevel'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>true, 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_hardLimit'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_hardLimit'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'inputType'               => 'checkbox',
	'eval'                    => array('mandatory'=>false, 'isBoolean'=>true, 'tl_class'=>'clr'),
	'sql'                     => "smallint(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_reference'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_reference'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_referenceCategory'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['download_referenceCategory'],
	'exclude'                 => true,
	'inputType'               => 'treePicker',
	'eval'                    => array
	(
		'foreignTable'    => 'tl_download_structure',
		'titleField'      => 'title',
		'searchField'     => 'title',
		'managerHref'     => 'do=theme&table=tl_module',
		'fieldType'       => 'radio',
		'multiple'        => false,
		'pickerCallback'  => function($row) {
			return $row['title'] . ' [' . $row['id'] . ']';
		}
	),
	'sql'                     => "blob NULL"
);

//$GLOBALS['TL_DCA']['tl_module']['fields']['download_archiv'] = array
//(
//	'label'                   => &$GLOBALS['TL_LANG']['tl_download_archiv']['download_archiv'],
//	'inputType'               => 'checkboxWizard',
//	'exclude'                 => true,
//	'foreignKey'              => 'tl_download_archiv.title',
//	'eval'                    => array('mandatory'=>true, 'multiple'=>true),
//	'sql'                     => "blob NOT NULL"
//);

$GLOBALS['TL_DCA']['tl_module']['fields']['category_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['category_template'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'options_callback'        => array('tl_module_download', 'getCategoryTemplates'),
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_node_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['category_template'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'options_callback'        => array('tl_module_download', 'getNodeTemplates'),
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

class tl_module_download extends Backend
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCategory()
	{
		$objModule = \ModuleModel::findById(\Input::get('id'));

		if($objModule->download_archiv) {
			$objData = $this->Database->prepare("SELECT * FROM tl_download_category WHERE pid=?")->execute($objModule->download_archiv);
			while($objData->next()) {
				$arrData[$objData->id] = $objData->title;
			}

			return $arrData;
		}
	}

	public function getCategoryTemplates()
	{
		return $this->getTemplateGroup('category_');
	}

	public function getNodeTemplates()
	{
		return $this->getTemplateGroup('dn_');
	}
}
