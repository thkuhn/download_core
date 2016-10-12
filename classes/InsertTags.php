<?php

namespace CDK\Classes;

class InsertTags
{
	public function myReplaceInsertTags($strTag)
	{
		$objDB = \Database::getInstance();

		if ($strTag == 'download::category')
		{
			$objCategory = $objDB->prepare("SELECT * FROM tl_download_structure WHERE alias=?")->execute(\Input::get('category'));
			return $objCategory->title;
		}

		return false;
	}
}
