<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 21.04.18
 * Time: 13:22
 */

namespace App\Controller;


use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use App\Service\PokemonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PokemonController extends Controller
{
    /**
     * @var PokemonService
     */
    private $pokemonService;

    /**
     * PokemonController constructor.
     * @param PokemonService $pokemonService
     */
    public function __construct(PokemonService $pokemonService){
        $this->pokemonService = $pokemonService;
    }


    /**
     * @Route(path="/poke/{id}", name="poke")
     * @param int $id
     * @return Response
     */
    public function indexActionOne(int $id)
    {
        $pokemon = $this->pokemonService->getPokemonById($id);

        return $this->render("pages/poke.html.twig", [
            "pokemon" => $pokemon
        ]);
    }

    /**
     * @Route(path="/poke", name="pokeList")
     * @return Response
     */
    public function indexActionList(){
        $pokemons = $this->pokemonService->getAll();

        return $this->render("pages/pokeList.html.twig", [
            "pokemons" => $pokemons
        ]);
    }
}