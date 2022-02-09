<?php

namespace App\Tests;

use App\Service\RecalculateIngredientsService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RecalculateIngredientsTest extends TestCase
{
    public function testReadAndDecodeIngredientsFile(): void
    {
        $ingredients = file_get_contents(__DIR__ . '/files/ingredients.json');
        $ingredientsArray = json_decode(preg_replace( "/\r|\n/", "", $ingredients), true);

        $this->assertIsArray($ingredientsArray);
    }
}
