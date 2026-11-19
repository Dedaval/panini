<?php

namespace App\Controllers;

use App\Models\Cards;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CardsController extends RenderController
{
    public function getAllCards(Request $request, Response $response): Response
    {
        $cards = Cards::findAll();
        $page = 'cards';
        return $this->render($response, $page, [
            'cards' => $cards,
        ]);
    }

    public function getCardWithId(Request $request, Response $response, array $args): Response
    {
        $card = Cards::findById((int) $args['id']);

        if ($card === null) {
            $response->getBody()->write('Carte introuvable');
            return $response->withStatus(404);
        }

        return $this->render($response, 'card', [
            'card' => $card,
        ]);
    }
}
