<?php
$uri    = $_SERVER["REQUEST_URI"]  ?? "/";
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

// For POST requests, directly include Laravel (prevents CSRF issues)
if ($method === "POST") {
    chdir(__DIR__ . "/nephroapp/public");
    require __DIR__ . "/nephroapp/public/index.php";
    exit;
}

// For GET requests, redirect to Laravel
$query = $_SERVER["QUERY_STRING"] ?? "";
$dest = "/nephroapp/public" . $uri;
if ($query) $dest .= "?" . $query;
header("Location: " . $dest, true, 302);
exit;
?>
