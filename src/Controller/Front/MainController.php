<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductRepository;
use App\Repository\RecipeRepository;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('front/main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/product", name="product", methods={"GET"})
     * 
     * @return Response
     */
    public function product(ProductRepository $productRepository): Response
    {
        $listProducts = $productRepository->findAllProductsByNameAscQb();

        // On transmet à notre vue la liste des produits
        return $this->render(
            'front/main/product.html.twig',
            ["listProducts" => $listProducts]
        );
    }

    /**
     * @Route(
     *      "/product/{id}", 
     *      name="productShow", 
     *      methods={"GET"}, 
     *      requirements={"id"="\d+"})
     * 
     * @param int $id 
     * @return Response
     */
    public function productShow(int $id, ProductRepository $productRepository): Response
    {
        // On utilise le ProductRepository
        $dataProduct = $productRepository->find($id);

        // Si l'id contient un index qui n'existe pas
        if (is_null($dataProduct)) {

            // on lance une exception qui est particulière
            // puisqu'elle renvoie aussi au navigateur un status HTTP 404
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        // on renvoie le template twig dans lequel on transmet les données du produit demandé en paramètre
        return $this->render(
            'main/product-show.html.twig',
            [
                'product' => $dataProduct
            ]
        );
    }

    /**
     * @Route("/recipe", name="recipe", methods={"GET"})
     * 
     * @return Response
     */
    public function recipe(RecipeRepository $recipeRepository): Response
    {
        $listRecipes = $recipeRepository->findAllRecipesByNameAscQb();

        // On transmet à notre vue la liste des recettes
        return $this->render(
            'front/main/recipe.html.twig',
            ["listRecipes" => $listRecipes]
        );
    }

    /**
     * @Route(
     *      "/recipe/{id}", 
     *      name="recipeShow", 
     *      methods={"GET"}, 
     *      requirements={"id"="\d+"})
     * 
     * @param int $id 
     * @return Response
     */
    public function recipeShow(int $id, RecipeRepository $recipeRepository): Response
    {
        // On utilise le RecipeRepository
        $dataRecipe = $recipeRepository->find($id);

        // Si l'id contient un index qui n'existe pas
        if (is_null($dataRecipe)) {

            // on lance une exception qui est particulière
            // puisqu'elle renvoie aussi au navigateur un status HTTP 404
            throw $this->createNotFoundException('La recette n\'existe pas.');
        }

        // on renvoie le template twig dans lequel on transmet les données du produit demandé en paramètre
        return $this->render(
            'main/recipe-show.html.twig',
            [
                'recipe' => $dataRecipe
            ]
        );
    }
}
