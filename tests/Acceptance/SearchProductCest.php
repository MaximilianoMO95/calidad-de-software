<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class SearchProductCest
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
    }

    public function tryToTestSearchExistingProductByName(AcceptanceTester $I): void
    {
        $product = $I->grabEntryFromDatabase(
            'products', [
                'id_producto' => $this->productId
            ]
        );

        $I->fillField('input[type="text"]', $product['nombre_producto']);

        $I->canSee($product['nombre_producto']);
        $I->canSee($product['codigo_producto']);
    }
}
