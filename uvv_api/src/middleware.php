<?php
// Application middleware

$container = $app->getContainer();

$app->add(new \Slim\Middleware\JwtAuthentication([
  "path" => ["/api"],
  "passthrough" => ["/api/adherents/count"],
  "relaxed" => ["localhost", "docker"],
  "secret" => $container->get('settings')['jwt']['secret']
]));