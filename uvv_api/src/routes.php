<?php

use Slim\Http\Request;
use Slim\Http\Response;

use Objects\AdherentMapper;
use Objects\ClubMapper;

// Routes

$app->post('/api/login', function (Request $request, Response $response, array $args) {
    $this->logger->info("UVV API /api/login");

    $data = $request->getParsedBody();
    $mail = filter_var($data['mail'], FILTER_SANITIZE_STRING);
    $password = filter_var($data['password'], FILTER_SANITIZE_STRING);
    $encpass = md5($password);

    $this->logger->info("UVV API /api/login", ["mail"=>$mail, "data"=>$data, "body"=>$request->getBody()]);

    $club_mapper = new ClubMapper($this->db);
    $club = $club_mapper->checkClub($mail, $encpass);

    if ($club) {
        $now = new DateTime();
        $future = new DateTime("now +24 hours");
        $jti = \Tuupola\Base62::encode(random_bytes(16));

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            "club" => $club
        ];

        $secret = $this["settings"]["jwt"]["secret"];
        $token = \Firebase\JWT\JWT::encode($payload, $secret, "HS256");
        $repdata["status"] = "ok";
        $repdata["token"] = $token;
        $repdata["club"] = $club;

        $newresponse = $response->withJson($repdata);
    } else {
        $newresponse = $response->withStatus(418);
    }

    return $newresponse;
});

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