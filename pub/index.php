<?php

declare(strict_types=1);

require '../vendor/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false; // Liefere die angefragte Ressource direkt aus
}

if (strpos($_SERVER['REQUEST_URI'], '/api/') === 0) {
//    $api = new Api();
//    $api->sendResponse();

    echo '["\ud83d\udc34","\ud83e\udddd","\ud83e\udd34","\ud83d\udc78","\ud83e\udddd","\ud83d\udc34","\ud83d\uddfc","\ud83d\udc82","\ud83d\udc82","\ud83d\udc82","\ud83d\udc82","\ud83d\udc82","\ud83d\udc82","\ud83d\udc82","\ud83d\udc82","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\u2b1b","\u2b1c","\ud83d\udc6e","\ud83d\udc6e","\ud83d\udc6e","\ud83d\udc6e","\ud83d\udc6e","\ud83d\udc6e","\ud83d\udc6e","\ud83d\udc6e","\ud83e\udda5","\ud83d\uddfc","\ud83c\udff0","\ud83c\udfc3","\ud83e\udd35","\ud83d\udc70","\ud83c\udfc3","\ud83e\udda5","\ud83c\udff0"]';


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
echo '<h1>404 - Not found</h1>';
