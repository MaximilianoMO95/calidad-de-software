<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;

require_once __DIR__ . '/../../classes/Login.php'; use Login;

// Temporal solution until refactor the messy codebase
define('DB_USER', 'root');
define('DB_HOST', '127.0.0.1');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

class LoginTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    protected int $user_id;

    protected function _before(): void
    {
        $this->user_id = $this->tester->haveInDatabase(
            'users', [
            'firstname' => 'John',
            'lastname' => 'Wick',
            'user_name' => 'tank',
            'user_email' => 'john@wick.com',
            'user_password_hash' => '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO',
            'date_added' => '2024-03-12 15:06:00',
            ]
        );
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

    public function testLoginWithValidDataDb(): void
    {
        $_POST['login'] = true;
        $_POST['user_name'] = 'tank';
        $_POST['user_password'] = 'admin';

        $login = new Login();

        $this->assertEmpty($login->errors, 'Expected not errors in correct login');
        $this->assertTrue(session_status() !== PHP_SESSION_NONE);
        $this->assertTrue($_SESSION['user_id'] == $this->user_id);
        $this->assertTrue($_SESSION['user_login_status'] == 1);
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
