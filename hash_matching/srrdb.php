<?php

require_once(dirname(__FILE__)."/../bin/config.php");
require_once(WWW_DIR ."/lib/framework/db.php");
require_once(WWW_DIR ."/lib/util.php");
require_once ("hashcompare.php");

//This script is adapted from nZEDb predb.php script

$db = new DB();
		$newnames = 0;
		$releases = @simplexml_load_file('http://www.srrdb.com/feed/srrs');

        echo "Requesting pre info from srrdb.com  ...\n";

		if ($releases !== false)
		{
			foreach ($releases->channel->item as $release)
			{
				$oldname = $db->queryOneRow(sprintf("SELECT title FROM prehash WHERE title = %s", $db->escapeString($release->title)));
				if ($oldname["title"] == $release->title)
					continue;
				else
				{
					$db->query(sprintf("INSERT IGNORE INTO prehash (title, predate, adddate, source, hash) VALUES (%s, FROM_UNIXTIME(".strtotime($release->pubDate)."), now(),  %s, %s)", $db->escapeString($release->title), $db->escapeString("srrdb"), $db->escapeString(md5($release->title))));
					$newnames++;
				}
			}
		}
		return $newnames;



?>