<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class AddProductCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::LOGIN_PAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', 'admin');

        $I->click('login');
    }

    public function tryToTestAddOneProduct(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::STOCK_PAGE);
        $I->click('#nuevoProducto');

        $I->fillField('codigo', 'fake1');
        $I->fillField('nombre', 'fake product');
        $I->selectOption('categoria', '1');
        $I->fillField('precio', '1000');
        $I->fillField('stock', '10');

        $I->canSee('#guardar_datos');
        $I->click('#guardar_datos');
        $I->see('¡Bien hecho!');
    }

    public function tryToTestAddProductWithSameCode(AcceptanceTester $I): void
    {
        $I->haveInDatabase(
            'products', [
            'codigo_producto' => 'M002',
            'nombre_producto' =>  'Clavo',
            'date_added' => '2021-09-20 15:53:56',
            'precio_producto' => 5990,
            'stock' => 10,
            'id_categoria' => 12,
            ]
        );

        $I->amOnPage(CommonCest::STOCK_PAGE);
        $I->click('#nuevoProducto');

        $I->fillField('codigo', 'M002');
        $I->fillField('nombre', 'Clavo');
        $I->selectOption('categoria', '12');
        $I->fillField('precio', '2000');
        $I->fillField('stock', '10');

        $I->canSee('#guardar_datos');
        $I->click('#guardar_datos');
        $I->see('Error!');
    }

    public function tryToTestAddProductWithoutCategory(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::STOCK_PAGE);
        $I->click('#nuevoProducto');

        $I->fillField('codigo', 'M005');
        $I->fillField('nombre', 'Clavo');
        $I->selectOption('categoria', '');
        $I->fillField('precio', '2000');
        $I->fillField('stock', '10');

        $I->canSee('#guardar_datos');
        $I->click('#guardar_datos');
        $I->see('Error!');
    }

    public function tryToTestAddProductWithNotNumericPrice(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::STOCK_PAGE);
        $I->click('#nuevoProducto');

        $I->fillField('codigo', 'M005');
        $I->fillField('nombre', 'Clavo');
        $I->selectOption('categoria', '12');
        $I->fillField('precio', 'no a number');
        $I->fillField('stock', '10');

        $I->canSee('#guardar_datos');
        $I->click('#guardar_datos');
        $I->see('Error!');
    }

    public function tryToTestAddProductWithSameName(AcceptanceTester $I): void
    {
        $I->haveInDatabase(
            'products', [
            'codigo_producto' => 'M002',
            'nombre_producto' =>  'Clavo',
            'date_added' => '2021-09-20 15:53:56',
            'precio_producto' => 5990,
            'stock' => 10,
            'id_categoria' => 12,
            ]
        );

        $I->amOnPage(CommonCest::STOCK_PAGE);
        $I->click('#nuevoProducto');

        $I->fillField('codigo', 'M002');
        $I->fillField('nombre', 'Clavo');
        $I->selectOption('categoria', '12');
        $I->fillField('precio', '2000');
        $I->fillField('stock', '1');

        $I->canSee('#guardar_datos');
        $I->click('#guardar_datos');
        $I->see('Error!');

        $I->amOnPage(CommonCest::STOCK_PAGE);
        $I->click('#nuevoProducto');

        $I->fillField('codigo', 'M002');
        $I->fillField('nombre', 'clavo');
        $I->selectOption('categoria', '12');
        $I->fillField('precio', '2000');
        $I->fillField('stock', '1');

        $I->canSee('#guardar_datos');
        $I->click('#guardar_datos');
        $I->see('Error!');
    }
}
