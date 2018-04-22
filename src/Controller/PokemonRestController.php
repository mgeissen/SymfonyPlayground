<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 22.04.18
 * Time: 11:31
 */

namespace App\Controller;


use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PokemonRestController extends Controller{

    /**
     * @Route(path="/api/pokemon", name="pokemon_api")
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function getAllPokemons(EntityManagerInterface $entityManager, SerializerInterface $serializer){
        $pokemons = $entityManager->getRepository(Pokemon::class)->findAll();
        $serializePokemons = $serializer->serialize($pokemons, 'json');

        return new Response($serializePokemons);
    }

}