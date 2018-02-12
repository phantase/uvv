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

}