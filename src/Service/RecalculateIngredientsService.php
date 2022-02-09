<?php

namespace App\Service;

use JsonException;

class RecalculateIngredientsService
{
    /**
     * @var int|mixed
     */
    private int $actualServings;
    /**
     * @var int
     */
    private int $newServings = 1;
    /**
     * @var array
     */
    private array $ingredientsArray;
    /**
     * @var array
     */
    private array $eachIngredients = [];
    /**
     * @var array
     */
    private array $newIngredients;

    /**
     *
     */
    public function __construct()
    {
        $this->ingredientsArray = $this->readAndDecodeIngredientsFile();
        $this->actualServings = $this->ingredientsArray['servings'];
        $this->newIngredients = [
            'title' => $this->ingredientsArray['title'],
            'servings' => $this->newServings,
            'ingredients' => []
        ];

        $this->setEachIngredient();
    }

    /**
     * @param int $servings
     * @return array
     */
    public function recalculateIngredients(int $servings): array
    {
        if ($servings <= 0) {
            $servings = 1;
        }

        $this->newServings = $servings;
        $this->newIngredients['servings'] = $this->newServings;
        $this->transformIngredients();

        return $this->newIngredients;
    }

    /**
     * @return array
     */
    private function readAndDecodeIngredientsFile(): array
    {
        try {
            $ingredients = file_get_contents('assets/ingredients.json');
            $jsonArray = json_decode(preg_replace( "/\r|\n/", "", $ingredients), true);

            if (is_null($jsonArray)) {
                throw new \Exception('JSON decode error.');
            }

            return $jsonArray;
        } catch (JsonException $exception) {
            die($exception);
        }
    }

    /**
     * @return void
     */
    private function transformIngredients(): void
    {
        foreach ($this->ingredientsArray['ingredients'] as $ingredient) {
            $this->newIngredients['ingredients'][] = $this->calculateIngredient($ingredient);
        }
    }

    /**
     * @param array $ingredient
     * @return array
     */
    private function calculateIngredient(array $ingredient): array
    {
        $amount = $this->eachIngredients[$ingredient['name']] * $this->newServings;

        if ($ingredient['unit'] === 'piece') {
            $amount = ceil($amount);
        }

        $ingredient['amount'] = $amount;

        return $ingredient;
    }

    /**
     * @return void
     */
    private function setEachIngredient(): void
    {
        foreach ($this->ingredientsArray['ingredients'] as $ingredient) {
            $this->eachIngredients[$ingredient['name']] = $ingredient['amount'] / $this->actualServings;
        }
    }
}