<?php

namespace pixelSpreadde\Classes;

class InsertTags {
	public function myReplaceInsertTags($strTag)
	{
		$objDB = \Database::getInstance();
		
		if ($strTag == 'download::category')
		{
			$objCategory = $objDB->prepare("SELECT * FROM tl_download_category WHERE alias=?")->execute(\Input::Get('category'));
			return $objCategory->title;
		}

		return false;
	}
}