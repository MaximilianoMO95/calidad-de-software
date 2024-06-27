<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class DeleteProductCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::LOGIN_PAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', 'admin');

        $I->click('login');
    }

    public function tryToTestDeleteOneProduct(AcceptanceTester $I): void
    {
        $I->haveInDatabase(
            'products', [
            'id_producto' => '100',
            'codigo_producto' => 'M002',
            'nombre_producto' =>  'Clavo',
            'date_added' => '2021-09-20 15:53:56',
            'precio_producto' => 5990,
            'stock' => 10,
            'id_categoria' => 12,
            ]
        );

        $I->amOnPage(CommonCest::PRODUCT_PAGE . '?id=100');
        $I->click('Eliminar');
        $I->wantToTest("The popup but I can't without the webdriver");
        // TODO: Add webdriver and test popup
    }
}
