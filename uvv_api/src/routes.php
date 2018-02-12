<?php

use Slim\Http\Request;
use Slim\Http\Response;

use Objects\AdherentMapper;
use Objects\ClubMapper;

// Routes

$app->get('/api/adherents/count', function (Request $request, Response $response, array $args) {
    $this->logger->info("UVV API /api/adherents/count");

    $adherent_mapper = new AdherentMapper($this->db);
    $count = $adherent_mapper->count();

    return $response->withJson(array('count' => $count), 201);
});

$app->get('/api/adherents', function (Request $request, Response $response, array $args) {
    $this->logger->info("UVV API /api/adherents");

    $adherent_mapper = new AdherentMapper($this->db);
    $adherents = $adherent_mapper->getAdherents();

    return $response->withJson($adherents, 201);
});

$app->get('/api/clubs/count', function (Request $request, Response $response, array $args) {
    $this->logger->info("UVV API /api/clubs/count");

    $club_mapper = new ClubMapper($this->db);
    $count = $club_mapper->count();

    return $response->withJson(array('count' => $count), 201);
});

$app->get('/api/clubs', function (Request $request, Response $response, array $args) {
    $this->logger->info("UVV API /api/clubs");

    $club_mapper = new ClubMapper($this->db);
    $clubs = $club_mapper->getClubs();

    return $response->withJson($clubs, 201);
});