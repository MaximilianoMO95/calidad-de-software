<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;

require_once __DIR__ . '/../../classes/Login.php'; use Login;

class LoginTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before(): void
    {
    }

    protected function _after(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            session_destroy();
        }
    }

    public function testConstructor(): void
    {
        $login = new Login();
        $this->assertIsObject($login);
        $this->assertEmpty($login->errors);
        $this->assertEmpty($login->messages);
    }

    public function testLoginWithEmptyUsername(): void
    {
        $_POST['login'] = true;
        $_POST['user_name'] = '';
        $_POST['user_password'] = 'password';

        $login = new Login();
        $this->assertNotEmpty($login->errors, 'Expected an error got nothing');
    }

    public function testLoginWithEmptyPassword(): void
    {
        $_POST['login'] = true;
        $_POST['user_name'] = 'username';
        $_POST['user_password'] = '';

        $login = new Login();
        $this->assertNotEmpty($login->errors, 'Expected an error got nothing');
    }

    public function testLogout(): void
    {
        $login = new Login();
        $login->doLogout();
        $this->assertTrue(session_status() === PHP_SESSION_NONE);
    }

    public function testIsUserLoggedIn(): void
    {
        $login = new Login();
        $_SESSION['user_login_status'] = 1;
        $this->assertTrue($login->isUserLoggedIn());

        $_SESSION['user_login_status'] = 0;
        $this->assertFalse($login->isUserLoggedIn());
    }
}
