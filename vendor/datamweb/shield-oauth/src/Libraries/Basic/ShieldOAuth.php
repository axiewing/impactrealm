<?php

declare(strict_types=1);

/**
 * This file is part of Shield OAuth.
 *
 * (c) Datamweb <pooya_parsa_dadashi@yahoo.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Datamweb\ShieldOAuth\Libraries\Basic;

use CodeIgniter\Config\Factories;
use CodeIgniter\Files\FileCollection;

class ShieldOAuth
{
    private $oauthClassFiles = '';

    public static function setOAuth(string $serviceName): object
    {
        $serviceName = ucfirst($serviceName);
        $className   = '\Datamweb\ShieldOAuth\Libraries\\' . $serviceName . 'OAuth';

        // For to detect custom OAuth
        if (file_exists(APPPATH . 'Libraries/ShieldOAuth' . DIRECTORY_SEPARATOR . $serviceName . 'OAuth.php')) {
            $className = 'App\Libraries\ShieldOAuth\\' . $serviceName . 'OAuth';
        }

        return $oauthClass = Factories::loadOAuth($className);
    }

    /**
     * --------------------------------------------------------------------
     * Names of all supported services
     * --------------------------------------------------------------------
     * Here we have recorded the list of all the services with which it is possible to login.
     *
     * Returns the names of all supported services for use in routes
     * e.g. 'github|google|yahoo|...'
     * Note: @see https://codeigniter.com/user_guide/incoming/routing.html#custom-placeholders
     */
    public function allOAuth(): string
    {
        $files = new FileCollection();
        // Checking if it is installed manually
        if (array_key_exists('Datamweb\ShieldOAuth', Config('Autoload')->psr4)) {
            // Adds all Libraries files
            $files = $files->add(APPPATH . 'ThirdParty/shield-oauth/src/Libraries', false);
        } else {
            // Adds all Libraries files if install via composer
            $files = $files->add(VENDORPATH . 'datamweb/shield-oauth/src/Libraries', false);
        }
        // For to detect custom OAuth
        if (is_dir(APPPATH . 'Libraries/ShieldOAuth')) {
            $files = $files->add(APPPATH . 'Libraries/ShieldOAuth', false);
        }
        // show only all *OAuth.php files
        $files = $files->retainPattern('*OAuth.php');

        $this->setOtherOAuth($files);

        $allAllowedRoutes = '';

        foreach ($files as $file) {
            // make string github|google and ... from class name
            $allAllowedRoutes .= strtolower(str_replace($search = 'OAuth.php', $replace = '|', $subject = $file->getBasename()));
        }

        return mb_substr($allAllowedRoutes, 0, -1);
    }

    public function setOtherOAuth($files)
    {
        return $this->oauthClassFiles = $files;
    }

    private function otherOAuth(): array
    {
        $files            = $this->oauthClassFiles;
        $allAllowedRoutes = '';

        foreach ($files as $file) {
            // make string github|google and ... from class name
            $allAllowedRoutes .= strtolower(str_replace($search = 'OAuth.php', $replace = '|', $subject = $file->getBasename()));
        }
        $allAllowedRoutes = mb_substr($allAllowedRoutes, 0, -1);

        $pieces = explode('|', $allAllowedRoutes);

        return array_diff($pieces, ['github', 'google']);
    }

    public function makeOAuthButton(string $forPage = 'login'): string
    {
        $active_by = lang('ShieldOAuthLang.login_by');
        if ($forPage === 'register') {
            $active_by = lang('ShieldOAuthLang.register_by');
        }

        $Button = "<hr>
        <div class='text-center'>
                 <div class='btn-group' role='group' aria-label='Button group with nested dropdown'>
                 <a href='#' class='btn btn-primary active' aria-current='page'>" . $active_by . '</a>';

        $Button .= '<a href=' . base_url('oauth/google') . ' ' . "class='btn btn-outline-secondary' aria-current='page'>" . lang('ShieldOAuthLang.Google.google') . '</a>';
        $Button .= '<a href=' . base_url('oauth/github') . ' ' . "class='btn btn-outline-secondary' aria-current='page'>" . lang('ShieldOAuthLang.Github.github') . '</a>';
        if (count($this->otherOAuth()) > 0) {
            $Button .= "<div class='btn-group' role='group'>
                            <button type='button' class='btn btn-outline-secondary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>"
                            . lang('ShieldOAuthLang.other') . "
                            </button>
                            <ul class='dropdown-menu'>";

            foreach ($this->otherOAuth() as $oauthName) {
                $OAuthName = ucfirst($oauthName);
                $Button .= "<li><a class='dropdown-item' href=" . base_url("oauth/{$oauthName}") . '>' . lang("ShieldOAuthLang.{$OAuthName}.{$oauthName}") . '</a></li>';
            }
            $Button .= '</ul></div>';
        }

        $Button .= '
        </div>
        </div>';

        return $Button;
    }
}
