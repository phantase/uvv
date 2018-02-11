<?php

namespace Objects;

class AdherentEntity implements \JsonSerializable
{
  protected $idbdd;
  protected $numlicence;
  protected $nom;
  protected $prenom;
  protected $datenaissance;
  protected $adrvoie;
  protected $adrcp;
  protected $adrville;
  protected $mail;
  protected $telfixe;
  protected $telport;
  protected $grade;
  protected $categorie;
  protected $gradec;
  protected $categoriec;
  protected $needcheck;

  public function __construct(array $data) {
    // no id if we're creating
    if(isset($data['idbdd'])) {
      $this->idbdd = $data['idbdd'];
    }

    $this->numlicence = $data['numlicence'];
    $this->nom = $data['nom'];
    $this->prenom = $data['prenom'];
    $this->datenaissance = $data['datenaissance'];
    $this->adrvoie = $data['adrvoie'];
    $this->adrcp = $data['adrcp'];
    $this->adrville = $data['adrville'];
    $this->mail = $data['mail'];
    $this->telfixe = $data['telfixe'];
    $this->telport = $data['telport'];
    $this->grade = $data['grade'];
    $this->categorie = $data['categorie'];
    $this->gradec = $data['gradec'];
    $this->categoriec = $data['categoriec'];
    $this->needcheck = $data['needcheck'];
  }

  public function getIdbdd() {
    return $this->idbdd;
  }
  public function getNumlicence() {
    return $this->numlicence;
  }
  public function getNom() {
    return $this->nom;
  }
  public function getPrenom() {
    return $this->prenom;
  }
  public function getDatenaissance() {
    return $this->datenaissance;
  }
  public function getAdrvoie() {
    return $this->adrvoie;
  }
  public function getAdrcp() {
    return $this->adrcp;
  }
  public function getAdrville() {
    return $this->adrville;
  }
  public function getMail() {
    return $this->mail;
  }
  public function getTelfixe() {
    return $this->telfixe;
  }
  public function getTelport() {
    return $this->telport;
  }
  public function getGrade() {
    return $this->grade;
  }
  public function getCategorie() {
    return $this->categorie;
  }
  public function getGradec() {
    return $this->gradec;
  }
  public function getCategoriec() {
    return $this->categoriec;
  }
  public function getNeedCheck() {
    return $this->needCheck;
  }

  public function jsonSerialize() {
    return [
      'idbdd' => $this->idbdd,
      'numlicence' => $this->numlicence,
      'nom' => $this->nom,
      'prenom' => $this->prenom,
      'datenaissance' => $this->datenaissance,
      'adrvoie' => $this->adrvoie,
      'adrcp' => $this->adrcp,
      'adrville' => $this->adrville,
      'mail' => $this->mail,
      'telfixe' => $this->telfixe,
      'telport' => $this->telport,
      'grade' => $this->grade,
      'categorie' => $this->categorie,
      'gradec' => $this->gradec,
      'categoriec' => $this->categoriec,
      'needcheck' => $this->needcheck
    ];
  }
}