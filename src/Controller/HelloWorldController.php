<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 21.04.18
 * Time: 11:18
 */

namespace App\Controller;


use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends Controller{

    /**
     * @Route(path="/hello", name="hello_world")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function indexAction(EntityManagerInterface $entityManager): Response {

            $repo = $entityManager->getRepository(Pokemon::class);
            $pokemon = $repo->find(1);
            $name = $pokemon->getName();

        return $this->render("pages/hello.html.twig", [
            "name" => $name
        ]);
    }
}