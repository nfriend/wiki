<?php

$pageName = isset($_POST["pageName"]) ? $_POST["pageName"] : null;
$pageContent = isset($_POST["pageContent"]) ? $_POST["pageContent"] : null;

if (!$pageName) {
  http_response_code(500);
  printf("No page name was provided!");
}

if (!$pageContent) {
  http_response_code(500);
  printf("No page content was provided!");
}

$pageName = strtoupper($pageName);

$mysqli = new mysqli("localhost", "wikiuser", "", "wiki");

if ($mysqli->connect_errno) {
  http_response_code(500);
  printf("Connect failed: %s\n", $mysqli->connect_error);
  exit();
}

$deleteQuery = $mysqli->prepare("DELETE FROM page WHERE name = ?");
$query = $mysqli->prepare("INSERT INTO page (name, content) VALUES (?, ?)");

if (!$query || !$deleteQuery) {
  http_response_code(500);
  printf("Prepare failed: %s\n", $mysqli->error);
  exit();
}

$deleteQuery->bind_param("s", $pageName);
$query->bind_param("ss", $pageName, $pageContent);

if ($deleteQuery->execute() && $query->execute()) {
  http_response_code(200);
  printf("Successfully saved page '" . $pageName . "'");
} else {
  http_response_code(500);
  printf("Unable to execute DELETE or INSERT query: ", $mysqli->error);
}

?>