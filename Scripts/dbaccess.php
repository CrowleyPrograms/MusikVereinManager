<?php
//TODO: create ini file and access servername username etc from that
//Note: Place it outside of root to prevent access from the web

function connect()
{
	static $conn;
	if (!isset($conn)){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "test";
		$conn = new mysqli($servername, $username, $password, $dbname);
	}
	if($conn === false) {
        return mysqli_connect_error(); 
    }
	return $conn;
}
function executeQuery($sql)
{
	$rows = array();
	$result = execute($sql);
	if ($result == false)
	{
		throw new Exception("No rows returned");
	}
	while ($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}
function execute($sql)
{
	$conn = connect();
	$result = $conn->query($sql);
	return $result;
}
function getError()
{
	$connection = connect();
    return $connection->error;
}

function test(){
	$conn = connect();
	echo "<p>testing...</p>";
	$rows = executeQuery("SELECT * FROM PERSON");
	foreach($rows as $row)
	{
		echo "<p>fetched: id:" . $row["id"] . " name: " . $row["name"] . "</p>";
	}
}
function setAutoCommit($value)
{
	$conn = connect();
	mysqli_autocommit($conn,$value);
}
function commit()
{
	$conn = connect();
	mysqli_commit($conn);
}
function close()
{
	mysql_close($conn);
}
?>
