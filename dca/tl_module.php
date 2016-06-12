<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['download_archiv']   = '{title_legend},name,headline,type;{config_legend},download_archiv,jumpTo;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['download_category'] = '{title_legend},name,headline,type;{template_legend:hide},category_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['download_index']    = '{title_legend},name,headline,type;{config_legend},download_archiv,jumpTo;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['download_archiv'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_download_archiv']['download_archiv'],
	'inputType'               => 'checkboxWizard',
	'exclude'                 => true,
	'foreignKey'              => 'tl_download_archiv.title',
	'eval'                    => array('mandatory'=>true, 'multiple'=>true),
	'sql'                     => "blob NOT NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['category_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['category_template'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'options_callback'        => array('tl_module_download', 'getCategoryTemplates'),
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
		$objModule = \ModuleModel::findById(\Input::Get('id'));

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
}
