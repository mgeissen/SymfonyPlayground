<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 22.04.18
 * Time: 11:31
 */

namespace App\Controller;


use App\Entity\Pokemon;
use App\Service\PokemonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PokemonRestController extends Controller{
    /**
     * @var PokemonService
     */
    private $pokemonService;

    /**
     * PokemonRestController constructor.
     * @param PokemonService $pokemonService
     */
    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }


    /**
     * @Route(path="/api/pokemon", name="pokemon_api")
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function getAllPokemons(SerializerInterface $serializer){
        $pokemons = $this->pokemonService->getAll();
        $serializePokemons = $serializer->serialize($pokemons, 'json');

        return new Response($serializePokemons);
    }

}