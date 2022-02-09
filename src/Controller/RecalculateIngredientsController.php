<?php

namespace App\Controller;

use App\Service\RecalculateIngredientsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecalculateIngredientsController extends AbstractController
{
    /**
     * @var RecalculateIngredientsService
     */
    private RecalculateIngredientsService $recalculateIngredientsService;

    /**
     * @param $recalculateIngredientsService
     */
    public function __construct($recalculateIngredientsService)
    {
        $this->recalculateIngredientsService = $recalculateIngredientsService;
    }

    /**
     * @Route("/recalculate/ingredients/{servings}", name="recalculate_ingredients")
     */
    public function index(int $servings = 1): Response
    {
        $ingredients = $this->recalculateIngredientsService->recalculateIngredients($servings);

        return $this->json([
            'servings' => $servings,
            'data' => $ingredients
        ]);
    }
}
