<?php 

header("Content-Type: application/javascript");

require_once __DIR__ . '/../config/config.php';
?>

window.BASE_URL = window.BASE_URL || "<?= BASE_URL?>";