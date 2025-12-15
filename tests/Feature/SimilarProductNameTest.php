<?php

use App\Models\Product;
use App\Rules\SimilarProductName;
use Illuminate\Support\Facades\Validator;

test('permite productos con el mismo nombre base y talla/grade distinta', function () {
    Product::factory()->create(['name' => 'Huevos A']);
    Product::factory()->create(['name' => 'Huevos AA']);

    $validator = Validator::make(
        ['name' => 'Huevos AAA'],
        ['name' => [new SimilarProductName()]],
    );

    expect($validator->passes())->toBeTrue();
});

test('bloquea duplicados exactos aunque cambie mayúsculas o espacios', function () {
    Product::factory()->create(['name' => 'Huevos AAA']);

    $validator = Validator::make(
        ['name' => '  HUEVOS   AAA  '],
        ['name' => [new SimilarProductName()]],
    );

    expect($validator->passes())->toBeFalse();
    expect($validator->errors()->first('name'))->toContain('demasiado similar');
});

test('sigue bloqueando nombres con typo muy similares', function () {
    Product::factory()->create(['name' => 'Arroz Premium']);

    $validator = Validator::make(
        ['name' => 'Arroz Premiumm'],
        ['name' => [new SimilarProductName()]],
    );

    expect($validator->passes())->toBeFalse();
});

