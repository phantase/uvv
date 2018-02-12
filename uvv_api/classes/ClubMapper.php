<?php

namespace Objects;

class ClubMapper extends Mapper
{
  public function count() {
    $sql = "SELECT count(*) AS count
            FROM uvv_clubs";
    $stmt = $this->db->query($sql);
    $row = $stmt->fetch();

    return $row['count'];
  }

  public function getClubs() {
    $sql = "SELECT c.numclub,
                    c.nom, c.mail,
                    c.appartenance, c.estcomite
            FROM uvv_clubs c";
    $stmt = $this->db->query($sql);

    $results = [];
    while($row = $stmt->fetch()) {
      $results[] = new ClubEntity($row);
    }
    return $results;
  }

  public function checkClub($mail, $encpass) {
    $sql = "SELECT c.numclub,
                    c.nom, c.mail,
                    c.appartenance, c.estcomite
            FROM uvv_clubs c
            WHERE c.mail = :mail AND c.password = :encpass";
    $stmt = $this->db->prepare($sql);
    $result = $stmt->execute(["mail" => $mail, "encpass" => $encpass]);

    if($row = $stmt->fetch()) {
      return new ClubEntity($row);
    }
  }

}