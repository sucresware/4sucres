<?php

namespace App\Achievements;

use App\Models\User;

class AchievementManager
{
    /**
     * List of achievements that should be checked by `probe()`.
     */
    const AVAILABLE_ACHIEVEMENTS = [
        \App\Achievements\Achievements\AlphaSucreAchievement::class,
        \App\Achievements\Achievements\BetaSucreAchievement::class,
        \App\Achievements\Achievements\ContributorAchievement::class,
        \App\Achievements\Achievements\CrazyPosterAchievement::class,
        \App\Achievements\Achievements\DebuggerAchievement::class,
        \App\Achievements\Achievements\DonatorAchievement::class,
        \App\Achievements\Achievements\GoodIdeaAchievement::class,
        \App\Achievements\Achievements\MindFreeAchievement::class,
        \App\Achievements\Achievements\ModeratorAchievement::class,
        \App\Achievements\Achievements\NewcomerFromHelloChrismasAchievement::class,
        \App\Achievements\Achievements\NewcomerFromOncheAchievement::class,
        \App\Achievements\Achievements\NewcomerFromPlayVideoGamesDotComAchievement::class,
        \App\Achievements\Achievements\NewcomerFromTheBunkerAchievement::class,
        \App\Achievements\Achievements\NewcomerFromTwoSugarsAchievement::class,
        \App\Achievements\Achievements\OlinuxAchievement::class,
        \App\Achievements\Achievements\OpenTheDoorAchievement::class,
        \App\Achievements\Achievements\RaiderAchievement::class,
        \App\Achievements\Achievements\PazzRaiderAchievement::class,
        \App\Achievements\Achievements\VeryGoodIdeaAchievement::class,
        \App\Achievements\Achievements\VocaBankAchievement::class,
        \App\Achievements\Achievements\TheLuckAchievement::class,
    ];

    /**
     * Checks if the given achievements can be unlocked by the given user.
     *
     * @param User              $user
     * @param array|string|null $achievements
     *
     * @return bool If not achievement is given, returns true
     */
    public function canUnlock(User $user, $achievements): bool
    {
        $achievements = $this->assertAchievements($achievements);

        return !\in_array(false, array_filter($achievements, function ($item) use ($user) {
            [ $class ] = $item;

            return (new $class())->canUnlock($user);
        }));
    }

    /**
     * Unlocks the given achievements for the given user.
     *
     * @param User         $user
     * @param array|string $achievements    A list of achievements
     * @param bool         $assertCanUnlock Checks that the user can actually unlock this achievement.
     *                                      Set false to force unlock.
     *
     * @return array This list of unlocked achievements
     */
    public function unlock(User $user, $achievements, bool $assertCanUnlock = false): array
    {
        $achievements = $this->assertAchievements($achievements);

        $unlocks = [];
        foreach ($achievements as $item) {
            [ $class, $notify ] = $item;
            $achievement = new $class();

            if ($assertCanUnlock && !$achievement->canUnlock($user)) {
                continue;
            }

            $achievement->unlock($user, $notify);
            $unlocks[] = $class;
        }

        return $unlocks;
    }

    /**
     * Scoots the given user to unlocks its available-and-not-yet-acquired achievements.
     *
     * @param User              $user
     * @param array|string|null $achievements if null, all achievements in self::AVAILABLE_ACHIEVEMENTS will be checked
     */
    public function probe(?User $user, $achievements = null)
    {
        if (null === $user) {
            return;
        }

        $achievements = $this->assertAchievements($achievements ?? self::AVAILABLE_ACHIEVEMENTS);

        foreach ($achievements as $item) {
            [ $class, $notify ] = $item;

            if ($this->canUnlock($user, $class)) {
                $this->unlock($user, $class, $notify);
            }
        }
    }

    /**
     * Asserts that achievement array is well-formatted and inherits AchivementInterface.
     *
     * @param array|string|null $achievements if null, all achievements in self::AVAILABLE_ACHIEVEMENTS will be checked
     *
     * @return array
     */
    private function assertAchievements($achievements): array
    {
        if (!\is_array($achievements)) {
            $achievements = [$achievements];
        }

        $result = [];
        foreach ($achievements as $achievement) {
            if (!\is_array($achievement)) {
                $achievement = [$achievement, true];
            }

            if (!\is_bool($achievement[1])) {
                throw new \InvalidArgumentException(
                    sprintf('The given array is not well-formatted. Index at position 2 should be a boolean, given %s.',
                    $achievement[1]));
            } elseif (null === $this->getAchievement($achievement[0])) {
                throw new \InvalidArgumentException(
                    sprintf('Could not find achievement %s.', $achievement[0]));
            }

            $result[] = $achievement;
        }

        return $result;
    }

    /**
     * Returns an instance of the given achievement or throws an exception.
     *
     * @throws InvalidArgumentException
     *
     * @return AchievementInterface
     */
    public function getAchievement($achievement)
    {
        $namespace = 'App\Achievements\Achievements\\';

        if (false !== strpos($namespace, $achievement)) {
            $achievement = $namespace . ltrim($achievement, '\\ \t\n\r\0\x0B');
        }

        if (!\class_exists($achievement)) {
            throw new \InvalidArgumentException(
                sprintf('The given achievement (%s) could not be found.', $achievement));
        } elseif (!\is_subclass_of($achievement, AchievementInterface::class)) {
            throw new \InvalidArgumentException(
                sprintf('%s does not inherit %s.', $achievement, AchievementInterface::class));
        }

        return new $achievement();
    }
}
