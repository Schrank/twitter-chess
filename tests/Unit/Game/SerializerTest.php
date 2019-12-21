<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\InvalidJsonDataException;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Position;

/**
 * @covers \Schrank\TwitterChess\Game\Serializer
 */
class SerializerTest extends TestCase
{
    private Serializer $serializer;

    public function testCurrentPlayerAfterUnserialize(): void
    {
        $currentPlayer = Color::BLACK;
        $data          = $this->getSerializedData($currentPlayer, uniqid('', true), []);

        $game = $this->serializer->unserialize($data);
        $this->assertSame($currentPlayer, $game->getCurrentPlayer()->toString());
    }

    /**
     * @param string $currentPlayer
     *
     * @return false|string
     */
    private function getSerializedData(string $currentPlayer, string $id, array $board)
    {
        $data = json_encode([
            'board'         => json_encode($board, JSON_THROW_ON_ERROR, 512),
            'currentPlayer' => $currentPlayer,
            'id'            => $id,
        ], JSON_THROW_ON_ERROR, 512);

        return $data;
    }

    public function testIdAfterUnserialize(): void
    {
        $id   = uniqid('', true);
        $data = $this->getSerializedData(Color::BLACK, $id, []);

        $game = $this->serializer->unserialize($data);
        $this->assertSame($id, $game->getId());
    }

    public function testFiguresAfterUnserialize(): void
    {
        $board = [
            'A1' => '🏰',
            'H5' => '🦥',
            'B6' => '🏃',
            'A2' => '🏃',
            'F5' => '🦥',
            'C3' => '🏰',
        ];
        $data  = $this->getSerializedData(Color::BLACK, uniqid('', true), $board);

        $game = $this->serializer->unserialize($data);
        foreach ($board as $position => $icon) {
            $this->assertSame($icon, $game->getBoard()->getFigureFromPosition(new Position($position))->getIcon());
        }
    }

    public function testThrowsExceptionIfJsonDoesNotContainBoard(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain board data.');

        $data = '[]';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfJsonDoesNotContainCurrentPlayer(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain current player.');

        $data = '{"board":"lala"}';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfCurrentPlayerIsNeitherWhiteNorBlack(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain current player.');

        $data = '{"board":"lala","currentPlayer":"grey"}';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfJsonDoesNotContainId(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain game id.');

        $data = '{"board":"lala","currentPlayer":"white"}';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfJsonIsInvalid(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data are invalid.');

        $data = 'd';

        $this->serializer->unserialize($data);
    }

    public function testSerializesSavesCurrentPlayer()
    {
        $game = $this->createMock(Game::class);
        $game->method('getCurrentPlayer')->willReturn(Color::black());
        $this->assertSame(
            Color::BLACK,
            json_decode($this->serializer->serialize($game), true, 512, JSON_THROW_ON_ERROR)['currentPlayer']
        );

    }

    public function testUnserializeSerializeGivesSameResult(): void
    {
        $this->markTestIncomplete('Implement me!');
    }

    protected function setUp(): void
    {
        $this->serializer = new Serializer();
    }

}
