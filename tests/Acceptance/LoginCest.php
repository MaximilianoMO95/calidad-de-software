<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class LoginCest
{
    public function _before(AcceptanceTester $I): void
    {
    }

    public function tryToTestValidCredentials(AcceptanceTester $I): void
    {
        $I->amOnPage(CommonCest::LOGIN_PAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', 'admin');

        $I->click('login');

        $I->amOnPage(CommonCest::STOCK_PAGE);
    }

    public function tryToTestInvalidCredentials(AcceptanceTester $I): void
    {
        // Invalid Password
        $I->amOnPage(CommonCest::LOGIN_PAGE);

        $I->fillField('user_name', 'admin');
        $I->fillField('user_password', '0');

        $I->click('login');

        $I->see('Error!');
    }
}
