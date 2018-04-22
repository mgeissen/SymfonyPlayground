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
    public function indexAction(int $id, EntityManagerInterface $entityManager)
    {
        $pokemon = $entityManager->getRepository(PokemonRepository::class)->find($id);

        if ($pokemon === null) {
            try {
                $apiResponse = json_decode(file_get_contents("http://pokeapi.co/api/v2/pokemon/$id"), true);

                $pokemon = new Pokemon();
                $pokemon->setId($id);
                $pokemon->setName($apiResponse["id"]);
                $pokemon->setImage($apiResponse["sprites"]["font_default"]);
                $pokemon->setHeight($apiResponse["height"]);
                $pokemon->setWeight($apiResponse["weight"]);

                $entityManager->persist($pokemon);
                $entityManager->flush();

            } catch (\Exception $e) {
                return new Response("No pokemon found for this ID");
            }
        }


        return $this->render("pages/poke.html.twig", [
            "pokemon" => $pokemon
        ]);
    }
}