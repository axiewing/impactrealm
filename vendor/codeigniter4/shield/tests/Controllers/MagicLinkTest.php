<?php

declare(strict_types=1);

namespace Tests\Controllers;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;
use Tests\Support\FakeUser;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class MagicLinkTest extends TestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use FakeUser;

    protected $namespace;

    protected function setUp(): void
    {
        parent::setUp();

        // Add auth routes
        $routes = service('routes');
        auth()->routes($routes);
        Services::injectMock('routes', $routes);
    }

    public function testAfterLoggedInNotAllowDisplayMagicLink(): void
    {
        $this->user->createEmailIdentity([
            'email'    => 'foo@example.com',
            'password' => 'secret123',
        ]);

        $result = $this->post('/login', [
            'email'    => 'foo@example.com',
            'password' => 'secret123',
        ]);

        $result = $this->get('/login/magic-link');
        $result->assertRedirectTo(config('Auth')->loginRedirect());
    }

    public function testShowValidateErrorsInMagicLink(): void
    {
        $result = $this->post('/login/magic-link', [
            'email' => 'foo@example',
        ]);

        $expected = ['email' => 'The Email Address field must contain a valid email address.'];

        $result->assertSessionHas('errors', $expected);
    }
}
