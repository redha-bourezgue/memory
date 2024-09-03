<?php
class Player {
    private $id;
    private $name;
    private $bestScore;
    private $mysqli;

    public function __construct($name, $mysqli) {
        $this->name = $name;
        $this->mysqli = $mysqli;
        $this->loadOrCreatePlayer();
    }

    private function loadOrCreatePlayer() {
        $query = "SELECT * FROM players WHERE name = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $this->name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $this->id = $row['id'];
            $this->bestScore = $row['best_score'];
        } else {
            $query = "INSERT INTO players (name) VALUES (?)";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("s", $this->name);
            $stmt->execute();
            $this->id = $stmt->insert_id;
            $this->bestScore = 0;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function updateBestScore($score) {
        if ($score > $this->bestScore) {
            $this->bestScore = $score;
            $query = "UPDATE players SET best_score = ? WHERE id = ?";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("ii", $score, $this->id);
            $stmt->execute();
        }
    }

    public static function getTopPlayers($mysqli) {
        $query = "SELECT name, best_score FROM players ORDER BY best_score DESC LIMIT 3";
        $result = $mysqli->query($query);
        
        $topPlayers = [];
        while ($row = $result->fetch_assoc()) {
            $topPlayers[] = $row;
        }

        return $topPlayers;
    }
}
?>
