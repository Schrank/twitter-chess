<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Web;

use Schrank\TwitterChess\Chess;
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
        /** @var Chess $game */
        $game = $this->serializer->unserialize($json);

        $game->move(
            new Position($from),
            new Position($to)
        );
        $this->persister->save(
        // TODO move serialization into Serializer class
            $game->getId(), $game->jsonSerialize()
        );

        return $game->getBoard()->toArray();
    }

    public function load(string $id): array
    {
        $json = $this->persister->load($id);
        /** @var Chess $game */
        $game = $this->serializer->unserialize($json);

        return $game->getBoard()->toArray();
    }

}