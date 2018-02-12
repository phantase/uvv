<?php

namespace Objects;

class ClubEntity implements \JsonSerializable
{
  protected $numclub;
  protected $nom;
  protected $mail;
  protected $appartenance;
  protected $estcomite;

  public function __construct(array $data) {
    // no id if we're creating
    if(isset($data['numclub'])) {
      $this->numclub = $data['numclub'];
    }

    $this->nom = $data['nom'];
    $this->mail = $data['mail'];
    $this->appartenance = $data['appartenance'];
    $this->estcomite = $data['estcomite'];
  }

  public function getNumclub() {
    return $this->numclub;
  }
  public function getNom() {
    return $this->nom;
  }
  public function getMail() {
    return $this->mail;
  }
  public function getAppartenance() {
    return $this->appartenance;
  }
  public function getEstcomite() {
    return $this->estcomite;
  }

  public function jsonSerialize() {
    return [
      'numclub' => $this->numclub,
      'nom' => $this->nom,
      'mail' => $this->mail,
      'appartenance' => $this->appartenance,
      'estcomite' => $this->estcomite
    ];
  }
}