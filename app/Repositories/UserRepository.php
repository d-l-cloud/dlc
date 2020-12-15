<?php

namespace App\Repositories;

use App\Models\User\User;
use App\Models\User\UserSocialLogin;
use Laravel\Socialite\Two\User as UserOAuth;

class UserRepository
{
    public function getUserBySocId(UserOAuth $user, string $socName) {
        $userInSystem = UserSocialLogin::query()
            ->where('id_in_soc', $user->id)
            ->where('type_auth', $socName)
            ->first();
        if (!empty($user->getNickname())) {
            $userName = $user->getNickname();
        }elseif (!empty($user->getName())) {
            $userName = $user->getName();
        }else{
            $userName = '';
        }

        if(is_null($userInSystem)) {
            if (!empty($user->getEmail())) {
                $findeUserId = User::query()->where('email', $user->getEmail())->first();
                if(is_null($findeUserId)) {
                    $addUserInSystem = new User();
                    $addUserInSystem->fill([
                        'name' => $userName,
                        'email' => !empty($user->getEmail())? $user->getEmail() : rand(10000,99999).'_'.time().'@email.email',
                        'password' => '',
                        'email_verified_at' => now(),
                        'avatar' => !empty($user->getAvatar())? $user->getAvatar() : ''
                    ]);
                    $addUserInSystem->save();
                    $userId=$addUserInSystem->id;
                }
                else {
                    $userId=$findeUserId->id;
                }
            }
            else {
                $addUserInSystem = new User();
                $addUserInSystem->fill([
                    'name' => $userName,
                    'email' => !empty($user->getEmail())? $user->getEmail() : rand(10000,99999).'_'.time().'@email.email',
                    'password' => '',
                    'email_verified_at' => now(),
                    'avatar' => !empty($user->getAvatar())? $user->getAvatar() : ''
                ]);
                $addUserInSystem->save();
                $userId=$addUserInSystem->id;
            }

            $addUserInSocNet = new UserSocialLogin();
            $addUserInSocNet->fill([
                'user_id' => $userId,
                'name' => $userName,
                'id_in_soc' => !empty($user->getId())? $user->getId(): '',
                'type_auth' => $socName,
                'avatar' => !empty($user->getAvatar())? $user->getAvatar(): ''
            ]);
            $addUserInSocNet->save();

        }
        else {
            $userId=$userInSystem->user_id;
        }
        $userInSystem = User::query()->where('id', $userId)->first();
        return $userInSystem;
    }
}
