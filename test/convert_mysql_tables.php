<?php
//This script converts tables to myisam , innodb dynamic or innodb compressed. Run like this : php convert_mysql_tables.php dinnodb

require_once(dirname(__FILE__)."/../bin/config.php"); 
require_once(WWW_DIR."lib/framework/db.php");

$sql = "SHOW tables";
$db = new DB();

if (isset($argv[1]) && $argv[1] == "myisam")
{ 
	$tables = $db->query($sql);
	foreach($tables as $row)
	{
		$tbl = $row['Tables_in_'.DB_NAME];
		printf("Converting $tbl\n");
		$db->query("ALTER TABLE $tbl ENGINE=MYISAM");
	}
}
else if (isset($argv[1]) && $argv[1] == "dinnodb")
{ 
	$tables = $db->query($sql);
	foreach($tables as $row)
	{
		$tbl = $row['Tables_in_'.DB_NAME];
		printf("Converting $tbl\n");
		$db->query("ALTER TABLE $tbl ENGINE=INNODB ROW_FORMAT=DYNAMIC");
	}
}
else if (isset($argv[1]) && $argv[1] == "cinnodb")
{ 
	$tables = $db->query($sql);
	foreach($tables as $row)
	{
		$tbl = $row['Tables_in_'.DB_NAME];
		printf("Converting $tbl\n");
		$db->query("ALTER TABLE $tbl ENGINE=INNODB ROW_FORMAT=COMPRESSED");
	}
}

else
{
	exit("\nERROR: Wrong argument.\n\n"
		."php convert_mysql_tables.php myisam	...: Converts all the tables to Myisam Dynamic.\n"
		."php convert_mysql_tables.php dinnodb	...: Converts all the tables to InnoDB Dynamic.\n"
		."php convert_mysql_tables.php cinnodb	...: Converts all the tables to InnoDB Compressed.\n\n");
}
