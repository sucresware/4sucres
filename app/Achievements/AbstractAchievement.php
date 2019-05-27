<?php

namespace App\Achievements;

use App\Models\Post;
use App\Models\User;
use App\Models\Achievement;
use App\Notifications\ReplyInDiscussion;
use App\Notifications\UnlockedAchievement;

/**
 * Implements the AchievementInterface to provide more functionnalities.
 */
abstract class AbstractAchievement implements AchievementInterface
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    /**
     * {@inheritdoc}
     * Every child achievement SHOULD call this (`parent::canUnlock`).
     */
    public function canUnlock(User $user): bool
    {
        $userHasAchievement = (bool) $user->achievements()->where('code', $this->getClassName())->count();

        return static::ENABLED && static::UNLOCKABLE && !$userHasAchievement;
    }

    /**
     * {@inheritdoc}
     */
    public function unlock(User $user, bool $notify = true): void
    {
        echo sprintf('Unlocked "%s" for @%s.', $this->getName() . "\r\n", $user->name);
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

    /**
     * {@inheritdoc}
     */
    public function getImage(): string
    {
        return 'unknown.png';
    }
}
