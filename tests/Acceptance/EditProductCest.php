<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Codeception\Util\Locator;

class EditProductCest
{
    protected int $productId;

    public function _before(AcceptanceTester $I): void
    {
        $this->productId = $I->haveInDatabase(
            'products', [
            'codigo_producto' => 'M002',
            'nombre_producto' =>  'Clavo',
            'date_added' => '2021-09-20 15:53:56',
            'precio_producto' => 5990,
            'stock' => 10,
            'id_categoria' => 12,
            ]
        );

        $I->amOnPage(CommonCest::LOGIN_PAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', 'admin');

        $I->click('login');
        $I->amOnPage(CommonCest::STOCK_PAGE);

        // Not working: unable to find link
        $link = Locator::href(CommonCest::PRODUCT_PAGE . '?id=' . $this->productId);
        $I->click($link);
    }

    public function tryToTestModifyProductName(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::PRODUCT_PAGE . '?id=' . $this->productId);
        $I->click('Editar');

        $I->fillField('mod_nombre', 'Martillo');

        $I->canSee('#actualizar_datos');
        $I->click('#actualizar_datos');
        $I->seeInDatabase(
            'products', [
            'nombre_producto' =>  'Martillo',
            ]
        );
    }

    public function tryToTestModifyProductCategory(AcceptanceTester $I): void
    {
        $categoryId = 100;
        $I->haveInDatabase(
            'categorias', [
            'id_categoria' => $categoryId,
            'nombre_categoria' =>  'Fake',
            'date_added' => '2021-09-20 15:53:56',
            'descripcion_categoria' => 'fake fake',
            ]
        );

        $I->amOnPage(CommonCest::PRODUCT_PAGE . '?id=' . $this->productId);
        $I->click('Editar');

        $I->selectOption('mod_categoria', $categoryId);

        $I->canSee('#actualizar_datos');
        $I->click('#actualizar_datos');
        $I->seeInDatabase(
            'products', [
            'id_categoria' => $categoryId,
            ]
        );
    }
}
