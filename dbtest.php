<?php
$dbhost = getenv("OPENSHIFT_EXTMYSQL_DB_HOST");
$dbport = getenv("OPENSHIFT_EXTMYSQL_DB_PORT");
$dbuser = getenv("OPENSHIFT_EXTMYSQL_DB_USERNAME");
$dbpwd = getenv("OPENSHIFT_EXTMYSQL_DB_PASSWORD");
$dbname = getenv("OPENSHIFT_EXTMYSQL_DB_NAME");
$connection = mysql_connect($dbhost.":".$dbport, $dbuser, $dbpwd);
if (!$connection) {
  echo "Could not connect to database";
} else {
  echo "Connected to database.<br>";
}
$dbconnection = mysql_select_db($dbname);
$query = "SELECT * from users";
$rs = mysql_query($query);
while ($row = mysql_fetch_assoc($rs)) {
  echo $row['user_id'] . " " . $row['username'] . "\n";
}
mysql_close();
?>