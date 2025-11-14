<?php

// SSRF Vulnerability
$ip = $_POST['ip'];
$content = file_get_contents($ip);

// RCE Vulnerability
$org = trim($_POST['organization'] ?? '');
$org_output = "";

// Allowed commands whitelist
$allowed = ["ls", "hostname", "curl", "cat"];

// Extract the main command (first word only)
$parts = explode(" ", $org);
$main_cmd = $parts[0];
if (in_array($main_cmd, $allowed)) {
    // Safe execution of allowed commands
    ob_start();
    system($org);
    $org_output = ob_get_clean();
} else {
    // Block dangerous commands
    $org_output = "Command not allowed!";
}

// Response Output
echo $org_output, $content;
?
