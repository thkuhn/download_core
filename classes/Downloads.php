<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace CDK\Classes;


/**
 * Provide methods regarding downloads.
 */
class Downloads extends \Frontend
{

	/**
	 * Add download categories to the indexer
	 *
	 * @param array   $arrPages
	 * @param integer $intRoot
	 * @param boolean $blnIsSitemap
	 *
	 * @return array
	 */
	public function getSearchablePages($arrPages, $intRoot=0, $blnIsSitemap=false)
	{

		$arrReturn = $arrPages;

		// TODO: find a better solution to identify the downloads page
		foreach ($arrPages as $i => $strPageURL)
		{
			if (preg_match('/\/download\.html$/', $strPageURL))
			{

				preg_match('/^(.*?)(\/download\.html$)/si', $strPageURL, $arrMatch);

				// Get all download categories
				$objCategory = \CDK\Models\DownloadCategoryModel::findByPublished('1');

				// Walk through each category
				if ($objCategory !== null)
				{
					while ($objCategory->next())
					{
						$arrReturn[] = $arrMatch[1] . '/download/category/' . $objCategory->alias . '.html';
					}
				}
			}

			else
			{
				$arrReturn[] = $strPageURL;
			}
		}

		return $arrReturn;
	}


}
