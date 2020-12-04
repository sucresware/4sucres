<?php

namespace App\Achievements\Achievements;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Achievements\AbstractAchievement;

class VocaBankAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = true;

    public function canUnlock(User $user): bool
    {
        try {
            $vocabank_oauth_client = DB::table('oauth_clients')->where('name', 'VocaBank')->first();
        } catch (\Exception $e) {
            return false;
        }

        $oauth_credentials = DB::table('oauth_access_tokens')
            ->where('client_id', $vocabank_oauth_client->id)
            ->where('user_id', $user->id)
            ->first();

        return parent::canUnlock($user) && ($oauth_credentials !== null);
    }

    public function getName(): string
    {
        return 'Et là vous m’entendez ? Allo ?!';
    }

    public function getDescription(): string
    {
        return 'A connecté son compte 4sucres à VocaBank';
    }

    public function getImage(): string
    {
        return 'vocabank.png';
    }

    public function isRare(): bool
    {
        return false;
    }
}
