<?php

declare(strict_types=1);

require '../vendor/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false; // Liefere die angefragte Ressource direkt aus
}

require '../templates/board.phtml';

