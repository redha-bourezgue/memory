<?php
class Card {
    private $id;
    private $value;
    private $flipped = false;
    private $matched = false;
    private $icon;

    public function __construct($id, $value, $icon) {
        $this->id = $id;
        $this->value = $value;
        $this->icon = $icon;
    }

    public function getId() {
        return $this->id;
    }

    public function getValue() {
        return $this->value;
    }

    public function isFlipped() {
        return $this->flipped;
    }

    public function setFlipped($flipped) {
        $this->flipped = $flipped;
    }

    public function isMatched() {
        return $this->matched;
    }

    public function setMatched($matched) {
        $this->matched = $matched;
    }

    public function getIcon() {
        return $this->icon ?: '';
    }
}
?>
