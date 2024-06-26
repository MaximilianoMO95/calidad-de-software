<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class AddProductCest
{
    private const PRODUCTPAGE = "stock.php";

    public function _before(AcceptanceTester $I): void
    {
        $I->amOnPage(LoginCest::LOGINPAGE);

        $I->fillField("user_name", "admin");
        $I->fillField("user_password", "admin");

        $I->click("login");
    }

    public function tryToTestAddOneProduct(AcceptanceTester $I): void
    {
        $I->amOnPage($this::PRODUCTPAGE);
        $I->click("#nuevoProducto");

        $I->fillField("codigo", "fake1");
        $I->fillField("nombre", "fake product");
        $I->selectOption("categoria", "1");
        $I->fillField("precio", "1000");
        $I->fillField("stock", "10");
    }
}
