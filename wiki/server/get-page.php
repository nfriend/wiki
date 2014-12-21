<?php

$pageName = isset($_POST["pageName"]) ? $_POST["pageName"] : null;

if (!$pageName) {
  $pageName = '';
}

$pageName = strtoupper($pageName);

$mysqli = new mysqli("localhost", "wikiuser", "", "wiki");

if ($mysqli->connect_errno) {
  http_response_code(500);
  printf("Connect failed: %s\n", $mysqli->connect_error);
  exit();
}

$query = $mysqli->prepare("SELECT content FROM page WHERE name = ?");

if (!$query) {
  http_response_code(500);
  printf("Prepare failed: %s\n", $mysqli->error);
  exit();
}

$query->bind_param("s", $pageName);

if ($result = $query->execute()) {
  $allRows = array();
  $result = $query->get_result();
  
  // note: if this is failing, you probably need to install php5-mysqlnd (a drop-in replacement for php5-mysql) 
  // AND enable it in your php.ini - add this to the bottom of your php.ini file:
  // extension=mysqlnd.so
  while($row = $result->fetch_assoc()) {
    $allRows[] = $row;
  }
  
  if (count($allRows) > 0) {
    http_response_code(200);
    printf($allRows[0]['content']);
  } else {
    http_response_code(400);
    printf('The page "' . $pageName . '" was not found.');
  }
  
} else {
  http_response_code(500);
  printf("Unable to execute SELECT query: ", $mysqli->error);
}

?>