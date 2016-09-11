<?php

namespace CDK\Models;

class DownloadItemModel extends \Model
{
	protected static $strTable = 'tl_download_item';

	public static function findByIds($arrIds, array $arrOptions=array())
	{
		if (!is_array($arrIds) || empty($arrIds))
		{
			return null;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.id IN(" . implode(",", array_filter($arrIds)) . ")");

#		// Check the publication status (see #4652)
#		if (!BE_USER_LOGGED_IN)
#		{
#			$time = time();
#			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
#		}
#
		if (!isset($arrOptions['order']))
		{
			$arrOptions['order'] = "t.sorting ASC";
		}

		return static::findBy($arrColumns, null, $arrOptions);
	}
}
