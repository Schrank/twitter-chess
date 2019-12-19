<?php

declare(strict_types=1);

require '../vendor/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false; // Liefere die angefragte Ressource direkt aus
}

if (strpos($_SERVER['REQUEST_URI'], '/api/') === 0) {
    require ApiRouter();

    return;
}

if ($_SERVER['REQUEST_URI'] === '/') {
    $page = 'login';
    require '../templates/base.phtml';

    return;
}
if ($_SERVER['REQUEST_URI'] === '/board') {
    $page = 'board';
    require '../templates/base.phtml';

    return;
}

http_response_code(404);
echo '<h1>404 - Not fouund</h1>';
