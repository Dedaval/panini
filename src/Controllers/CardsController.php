<?php
namespace App\Controllers;
use App\Models\Cards;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class CardsController extends RenderController
{
public function getAllEquipes(Request $request, Response $response): Response
{
$cards = Cards::findAll();
$page = 'cards';
return $this->render($response, $page, [
'cards' => $cards,
]);
}
}