<?php

namespace App\Achievements;

use App\Models\User;

interface AchievementInterface
{
    /**
     * Asserts that the given user can unlock this achievement.
     */
    public function canUnlock(User $user): bool;

    /**
     * Unlock and notifies the user.
     */
    public function unlock(User $user, bool $notify = true): void;

    /**
     * Gets the image name of this achievement.
     */
    public function getName(): string;

    /**
     * Gets the description of this achievement.
     */
    public function getDescription(): string;

    /**
     * Gets the image related to this achievement.
     */
    public function getImage(): string;

    /**
     * Gets the short class name of this achievement.
     */
    public function getClassName(): string;

    /**
     * Gets the rarity of this achievement.
     */
    public function getRarity(): bool;
}
