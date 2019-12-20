<?php

declare(strict_types=1);

use Schrank\TwitterChess\Game\FilePersister;
use Schrank\TwitterChess\Game\Serializer;
use Schrank\TwitterChess\Web\Api;

require '../vendor/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false; // Liefere die angefragte Ressource direkt aus
}

if (strpos($_SERVER['REQUEST_URI'], '/api/move/') === 0) {
    $api = new Api(new FilePersister(), new Serializer());
    echo json_encode($api->move($_POST['from'], $_POST['to'], $_POST['id']), JSON_THROW_ON_ERROR, 512);

    return;
}

if (strpos($_SERVER['REQUEST_URI'], '/api/load/') === 0) {
    $api = new Api(new FilePersister(), new Serializer());
    echo json_encode($api->load($_POST['id']), JSON_THROW_ON_ERROR, 512);

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
