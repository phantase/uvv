<?php

use Slim\Http\Request;
use Slim\Http\Response;

use Objects\AdherentMapper;

// Routes

$app->get('/adherents/count', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("UVV API /adherents/count");

    $adherent_mapper = new AdherentMapper($this->db);
    $count = $adherent_mapper->count();

    return $response->withJson(array('count' => $count), 201);
});

$app->get('/adherents', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("UVV API /adherents");

    $adherent_mapper = new AdherentMapper($this->db);
    $adherents = $adherent_mapper->getAdherents();

    return $response->withJson($adherents, 201);
});