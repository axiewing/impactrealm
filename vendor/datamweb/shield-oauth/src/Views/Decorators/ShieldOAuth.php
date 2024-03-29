<?php

/**
 * This file is part of Shield OAuth.
 *
 * (c) Datamweb <pooya_parsa_dadashi@yahoo.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Datamweb\ShieldOAuth\Views\Decorators;

use CodeIgniter\View\ViewDecoratorInterface;

class ShieldOAuth implements ViewDecoratorInterface
{
    public static function decorate(string $html): string
    {
        $shieldOAuthSnippets = [
            '{{ShieldOAuthButtonForLoginPage}}'    => service('ShieldOAuth')->makeOAuthButton('login'),
            '{{ShieldOAuthButtonForRegisterPage}}' => service('ShieldOAuth')->makeOAuthButton('register'),
        ];

        return strtr($html, $shieldOAuthSnippets);
    }
}
