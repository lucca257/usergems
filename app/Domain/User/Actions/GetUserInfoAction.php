<?php

namespace App\Domain\User\Actions;

use App\Domain\Company\DTOs\CompanyDto;
use App\Domain\User\DTOs\UserDto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetUserInfoAction
{
    const string URL_SUFIX = 'hiring/calendar-challenge/person/';
    const string TOKEN = '9d^XItOjTAGSG5ch';

    /**
     * @param  string  $email
     * @return UserDto
     */
    public function execute(string $email): UserDto
    {
        $userApiResponse = $this->request($email);
        $companyDto = null;

        if (isset($userApiResponse->company)) {
            $companyArray = (array) $userApiResponse->company;
            $companyDto = new CompanyDto(...$companyArray);
        }

        return new UserDto(
            $email,
            $userApiResponse->first_name ?? null,
            $userApiResponse->last_name ?? null,
            $userApiResponse->avatar ?? null,
            $userApiResponse->title ?? null,
            $userApiResponse->linkedin_url ?? null,
            $companyDto
        );
    }

    private function request(string $email): mixed
    {
        return Cache::remember("user_info_$email", 60 * 5, function () use ($email) {
            $url = env('INTEGRATION_API').self::URL_SUFIX.$email;
            $response = Http::withToken(self::TOKEN)->get($url);
            return $response->object();
        });
    }
}
