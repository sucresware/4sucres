<?php

namespace App\Achievements;

use App\Achievements\Achievements\AlphaSucreAchievement;
use App\Achievements\Achievements\BetaSucreAchievement;
use App\Achievements\Achievements\CrazyPosterAchievement;
use App\Achievements\Achievements\DonatorAchievement;
use App\Achievements\Achievements\ModeratorAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

class AchievementManager
{
    /**
     * List of achievements that should be checked by `probe()`.
     */
    const AVAILABLE_ACHIEVEMENTS = [
        AlphaSucreAchievement::class,
        BetaSucreAchievement::class,
        CrazyPosterAchievement::class,
        ModeratorAchievement::class,
        DonatorAchievement::class,
    ];

    /**
     * Checks if the given achievements can be unlocked by the given user.
     *
     * @param Authenticatable   $user
     * @param array|string|null $achievements
     *
     * @return bool If not achievement is given, returns true
     */
    public function canUnlock(Authenticatable $user, $achievements): bool
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
     * @param Authenticatable $user
     * @param array|string    $achievements    A list of achievements
     * @param bool            $assertCanUnlock Checks that the user can actually unlock this achievement.
     *                                         Set false to force unlock.
     *
     * @return array This list of unlocked achievements
     */
    public function unlock(Authenticatable $user, $achievements, bool $assertCanUnlock = false): array
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
     * @param Authenticatable   $user
     * @param array|string|null $achievements if null, all achievements in self::AVAILABLE_ACHIEVEMENTS will be checked
     */
    public function probe(?Authenticatable $user, $achievements = null)
    {
        // @todo Change this behavior? Otherwise, will crash if no user is passed.
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
