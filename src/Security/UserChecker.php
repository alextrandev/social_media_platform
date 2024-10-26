<?php

namespace App\Security;

use App\Entity\User;
use DateTime;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
  /**
   * Undocumented function
   *
   * @param User $user
   * @return void
   */
  public function checkPreAuth(UserInterface $user): void
  {
    if ($user->getBannedUntil() === null) {
      return;
    }

    $now = new DateTime();
    if ($now < $user->getBannedUntil()) {
      throw new AccessDeniedHttpException('The user is banned');
    }
  }

  /**
   * Undocumented function
   *
   * @param User $user
   * @return void
   */
  public function checkPostAuth(UserInterface $user): void {}
}
