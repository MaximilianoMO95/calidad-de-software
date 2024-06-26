<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class LoginCest
{
    public const LOGINPAGE = 'login.php';

    public function _before(AcceptanceTester $I): void
    {
    }

    public function tryToTestValidCredentials(AcceptanceTester $I): void
    {
        $I->amOnPage($this::LOGINPAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', 'admin');

        $I->click('login');

        $I->amOnPage('/stock.php');
    }

    public function tryToTestInvalidCredentials(AcceptanceTester $I): void
    {
        // Invalid Password
        $I->amOnPage($this::LOGINPAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', '0');

        $I->click('login');

        $I->see('Error!');
    }
}
