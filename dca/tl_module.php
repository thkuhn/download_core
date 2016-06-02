<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['download_archiv']   = '{title_legend},name,headline,type;{config_legend},download_archiv,jumpTo;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['download_category'] = '{title_legend},name,headline,type;{config_legend},download_archiv,download_category;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['download_archiv'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_download_archiv']['download_archiv'],
	'inputType'               => 'checkboxWizard',
	'exclude'                 => true,
	'foreignKey'              => 'tl_download_archiv.title',
	'eval'                    => array('mandatory'=>true, 'multiple'=>true),
	'sql'                     => "blob NOT NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['download_category'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_download_archiv']['download_category'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'options_callback'        => array('tl_module_download', 'getCategory'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

class tl_module_download extends Backend
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCategory()
	{
		$objModule = \ModuleModel::findById(\Input::Get('id'));

		if($objModule->download_archiv)
		{
			$objData = $this->Database->prepare("SELECT * FROM tl_download_category WHERE pid=?")->execute($objModule->download_archiv);
			while($objData->next())
			{
				$arrData[$objData->id] = $objData->title;
			}

			return $arrData;
		}
	}
}
