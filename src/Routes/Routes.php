<?php
use App\Controllers\AccueilController;
use App\Controllers\CardsController;
use Slim\App;

return function (App $app) {
    $app->get('/', [AccueilController::class, 'index']);
    $app->get('/cards', [CardsController::class, 'getAllCards']);
    $app->get('/cards/{id}', [CardsController::class, 'getCardWithId']);
};