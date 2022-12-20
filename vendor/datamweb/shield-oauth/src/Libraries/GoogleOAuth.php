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

namespace Datamweb\ShieldOAuth\Libraries;

use Datamweb\ShieldOAuth\Libraries\Basic\AbstractOAuth;

class GoogleOAuth extends AbstractOAuth
{
    private static $API_CODE_URL      = 'https://accounts.google.com/o/oauth2/v2/auth';
    private static $API_TOKEN_URL     = 'https://oauth2.googleapis.com/token';
    private static $API_USER_INFO_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';
    private static $APPLICATION_NAME  = 'SheildOAuth';
    protected string $token;
    protected string $client_id;
    protected string $client_secret;
    protected string $callbake_url;

    public function __construct(string $token = '')
    {
        $this->token  = $token;
        $this->client = \Config\Services::curlrequest();

        $this->config        = config('ShieldOAuthConfig');
        $this->callbake_url  = base_url('oauth/' . $this->config->call_back_route);
        $this->client_id     = $this->config->oauthConfigs['google']['client_id'];
        $this->client_secret = $this->config->oauthConfigs['google']['client_secret'];
    }

    public function makeGoLink(string $state): string
    {
        return self::$API_CODE_URL . "?response_type=code&client_id={$this->client_id}&scope=openid%20email%20profile&redirect_uri={$this->callbake_url}&state={$state}";
    }

    protected function fetchAccessTokenWithAuthCode(array $allGet): void
    {
        try {
            // send request to API URL
            $response = $this->client->request('POST', self::$API_TOKEN_URL, [
                'form_params' => [
                    'client_id'     => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'code'          => $allGet['code'],
                    'redirect_uri'  => $this->callbake_url,
                    'grant_type'    => 'authorization_code',
                ],
                'headers' => [
                    'User-Agent' => self::$APPLICATION_NAME . '/1.0',
                    'Accept'     => 'application/json',
                ],
            ]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        $token = json_decode($response->getBody())->access_token;
        $this->setToken($token);
        echo  '<input type="text" value="' . $token . '" name="" id="">';
    }

    protected function fetchUserInfoWithToken(): object
    {
        // send request to API URL
        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.googleapis.com/oauth2/v3/userinfo',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->getToken(),
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
        echo $this->getToken();
        echo $response;
        return json_decode($response);
    }

    protected function setColumnsName(string $nameOfProcess, $userInfo): array
    {
        if ($nameOfProcess === 'syncingUserInfo') {
            $usersColumnsName = [
                $this->config->usersColumnsName['first_name'] => $userInfo->given_name,
                $this->config->usersColumnsName['last_name']  => $userInfo->family_name,
                $this->config->usersColumnsName['avatar']     => $userInfo->picture,
            ];
        }

        if ($nameOfProcess === 'newUser') {
            $usersColumnsName = [
                // users tbl                                    // OAuth
                'username'                                    => $userInfo->given_name . random_string('numeric', 5),
                'email'                                       => $userInfo->email,
                'password'                                    => random_string('crypto', 32),
                'active'                                      => $userInfo->email_verified,
                $this->config->usersColumnsName['first_name'] => $userInfo->given_name,
                $this->config->usersColumnsName['last_name']  => $userInfo->family_name,
                $this->config->usersColumnsName['avatar']     => $userInfo->picture,
            ];
        }

        return $usersColumnsName;
    }
}
