<?php

namespace Objects;

class AdherentMapper extends Mapper
{
  public function count() {
    $sql = "SELECT count(*) AS count
            FROM uvv_adherents";
    $stmt = $this->db->query($sql);
    $row = $stmt->fetch();

    return $row['count'];
  }

  public function getAdherents() {
    $sql = "SELECT a.idbdd, 
                    a.numlicence,
                    a.nom, a.prenom,
                    a.datenaissance, 
                    a.adrvoie, a.adrcp, a.adrville,
                    a.mail, 
                    a.telfixe, a.telport, 
                    a.grade, a.categorie, 
                    a.gradec, a.categoriec,
                    a.needcheck
            FROM uvv_adherents a";
    $stmt = $this->db->query($sql);

    $results = [];
    while($row = $stmt->fetch()) {
      $results[] = new AdherentEntity($row);
    }
    return $results;
  }

}