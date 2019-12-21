<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Web;

use Schrank\TwitterChess\Exception\GameNotFoundException;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Game\Persister;
use Schrank\TwitterChess\Game\Serializer;
use Schrank\TwitterChess\Position;

class Api
{
    private Persister $persister;
    private Serializer $serializer;

    public function __construct(Persister $persister, Serializer $serializer)
    {
        $this->persister  = $persister;
        $this->serializer = $serializer;
    }

    public function move(string $from, string $to, string $id): array
    {
        $json = $this->persister->load($id);
        /** @var Game $game */
        $game = $this->serializer->unserialize($json);

        $game->move(
            new Position($from),
            new Position($to)
        );
        $this->persister->save(
            $game->getId(), $this->serializer->serialize($game)
        );

        return $game->getBoard()->toArray();
    }

    public function load(string $id): array
    {
        try {
            $json = $this->persister->load($id);
            /** @var Game $game */
            $game = $this->serializer->unserialize($json);
        } catch (GameNotFoundException $e) {
            $game = new Game($id);
            $this->persister->save($id, $this->serializer->serialize($game));
        }

        return $game->getBoard()->toArray();
    }

}
