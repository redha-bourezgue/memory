<?php
require_once 'Card.php';

class GameSession {
    private $cards = [];
    private $flippedIndices = [];
    private $moves = 0;
    private $isCompleted = false; // Track if the game is completed

    public function __construct($mysqli, $numPairs) {
        $this->selectAndShuffleCards($numPairs);
    }

    public function getMoves() {
        return $this->moves;
    }

    private function selectAndShuffleCards($numPairs) {
        $icons = [
            "codicon-heart", "codicon-star", "codicon-check", "codicon-flame", 
            "codicon-git-pull-request", "codicon-git-merge", "codicon-paintcan", 
            "codicon-github-alt", "codicon-mortar-board", "codicon-tools", 
            "codicon-rocket", "codicon-beaker"
        ];

        $cards = [];
        for ($i = 0; $i < $numPairs; $i++) {
            $icon = $icons[$i];
            $cards[] = new Card($i * 2, $i, $icon);
            $cards[] = new Card($i * 2 + 1, $i, $icon);
        }

        shuffle($cards);
        $this->cards = $cards;
    }

    public function getCards() {
        return $this->cards;
    }

    public function flipCard($index) {
        if (isset($this->cards[$index]) && !in_array($index, $this->flippedIndices) && !$this->cards[$index]->isMatched()) {
            $card = $this->cards[$index];
            $card->setFlipped(true);
            $this->flippedIndices[] = $index;
        }
    }

    public function checkMatch() {
        if (count($this->flippedIndices) === 2) {
            $this->moves++;
            $firstIndex = $this->flippedIndices[0];
            $secondIndex = $this->flippedIndices[1];
            $firstCard = $this->cards[$firstIndex];
            $secondCard = $this->cards[$secondIndex];

            if ($firstCard->getValue() === $secondCard->getValue()) {
                $firstCard->setMatched(true);
                $secondCard->setMatched(true);
                // Check if game is completed
                $this->isCompleted = array_reduce($this->cards, function($completed, $card) {
                    return $completed && $card->isMatched();
                }, true);
            } else {
                $firstCard->setFlipped(false);
                $secondCard->setFlipped(false);
            }

            $this->flippedIndices = [];
        }
    }

    public function isCompleted() {
        return $this->isCompleted;
    }

    public function getFlippedIndices() {
        return $this->flippedIndices;
    }
}
?>
