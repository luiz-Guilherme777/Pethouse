<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/conexao.php';
?>

<script src="<?= BASE_URL?>components/js/config.js.php"></script>