<?php

namespace App\Achievements;

use App\Models\Achievement;
use App\Models\User;
use App\Notifications\UnlockedAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Implements the AchievementInterface to provide more functionnalities.
 */
abstract class AbstractAchievement implements AchievementInterface
{
    const ENABLED = true;

    /**
     * {@inheritdoc}
     * Every child achievement SHOULD call this (`parent::canUnlock`).
     */
    public function canUnlock(Authenticatable $user): bool
    {
        $userHasAchievement = Achievement::where('code', $this->getClassName())
            ->first()
            ->hasUser($user);

        return static::ENABLED && !$userHasAchievement;
    }

    /**
     * {@inheritdoc}
     */
    public function unlock(Authenticatable $user, bool $notify = true): void
    {
        // dump(sprintf('Unlocked "%s" for @%s.', $this->getName(), $user->name));
        $user->achievements()->attach(Achievement::where('code', $this->getClassName())->first());

        if ($notify) {
            $user->notify(new UnlockedAchievement($this));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
