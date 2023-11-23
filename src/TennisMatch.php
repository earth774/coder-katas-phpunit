<?php

namespace App;

class TennisMatch
{
    /**
     * @var Player
     */
    protected Player $playerOne;

    /**
     * @var Player
     */
    protected Player $playerTwo;

    /**
     * Create a new TennisMatch.
     *
     * @param  Player  $playerOne
     * @param  Player  $playerTwo
     */
    public function __construct(Player $playerOne, Player $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
    }

    /**
     * Score the match.
     *
     * @return string
     */
    public function score(): string
    {
        if ($this->hasWinner()) {
            return 'Winner: ' . $this->leader()->name;
        }

        if ($this->hasAdvantage()) {
            return 'Advantage: ' . $this->leader()->name;
        }

        if ($this->isDeuce()) {
            return 'deuce';
        }

        return sprintf(
            "%s-%s",
            $this->playerOne->toTerm(),
            $this->playerTwo->toTerm(),
        );
    }

    /**
     * Get the current leader of the set.
     *
     * @return Player
     */
    protected function leader(): Player
    {
        return $this->playerOne->points > $this->playerTwo->points
            ? $this->playerOne
            : $this->playerTwo;
    }

    /**
     * Determine if the players are in deuce.
     *
     * @return bool
     */
    protected function isDeuce(): bool
    {
        if (!$this->hasReachedDeuceThreshold()) {
            return false;
        }

        return $this->playerOne->points === $this->playerTwo->points;
    }

    /**
     * Determine if both players have scored at least 3 points.
     *
     * @return bool
     */
    protected function hasReachedDeuceThreshold(): bool
    {
        return $this->playerOne->points >= 3 && $this->playerTwo->points >= 3;
    }

    /**
     * Determine if one player has the advantage.
     *
     * @return bool
     */
    protected function hasAdvantage(): bool
    {
        if (!$this->hasReachedDeuceThreshold()) {
            return false;
        }

        return !$this->isDeuce();
    }

    /**
     * Determine if there is a winner.
     *
     * @return bool
     */
    protected function hasWinner(): bool
    {
        if ($this->playerOne->points < 4 && $this->playerTwo->points < 4) {
            return false;
        }

        return abs($this->playerOne->points - $this->playerTwo->points) >= 2;
    }
}
