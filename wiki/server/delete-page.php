<?php

$pageName = isset($_POST["pageName"]) ? $_POST["pageName"] : null;

if (!$pageName) {
  http_response_code(500);
  printf("No page name was provided!");
}

$pageName = strtoupper($pageName);

$mysqli = new mysqli("localhost", "wikiuser", "", "wiki");

if ($mysqli->connect_errno) {
  http_response_code(500);
  printf("Connect failed: %s\n", $mysqli->connect_error);
  exit();
}

$deleteQuery = $mysqli->prepare("DELETE FROM page WHERE name = ?");

if (!$deleteQuery) {
  http_response_code(500);
  printf("Prepare failed: %s\n", $mysqli->error);
  exit();
}

$deleteQuery->bind_param("s", $pageName);

if ($deleteQuery->execute()) {
  http_response_code(200);
  printf("Successfully deleted page '" . $pageName . "'");
} else {
  http_response_code(500);
  printf("Unable to execute DELETE query: ", $mysqli->error);
}

?>