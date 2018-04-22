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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PokemonController extends Controller
{
    /**
     * @Route(path="/poke/{id}", name="poke")
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function indexActionOne(int $id, EntityManagerInterface $entityManager)
    {
        $pokemon = $entityManager->getRepository(Pokemon::class)->find($id);

        if ($pokemon === null) {
            try {
                $url = "http://pokeapi.co/api/v2/pokemon/$id";
                $apiResponse = json_decode(file_get_contents($url), true);

                $pokemon = new Pokemon();
                $pokemon->setId($apiResponse["id"]);
                $pokemon->setName($apiResponse["name"]);
                $pokemon->setHeight($apiResponse["height"]);
                $pokemon->setWeight($apiResponse["weight"]);
                $pokemon->setImage($apiResponse["sprites"]["front_default"]);

                $entityManager->persist($pokemon);
                $entityManager->flush();

            } catch (\Exception $e) {
                return new Response("No pokemon found for this ID - " . $e->getMessage());
            }
        }


        return $this->render("pages/poke.html.twig", [
            "pokemon" => $pokemon
        ]);
    }

    /**
     * @Route(path="/poke", name="pokeList")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function indexActionList(EntityManagerInterface $entityManager){
        $pokemons = $entityManager->getRepository(Pokemon::class)->findAll();

        return $this->render("pages/pokeList.html.twig", [
            "pokemons" => $pokemons
        ]);
    }
}