<?php

namespace App;

use App\observer\UserObserver;

class User implements UserObserver
{
    // Hors exercice mais notable:
    // Promotion du constructeur: https://www.php.net/manual/fr/language.oop5.decon.php#language.oop5.decon.constructor.promotion
    public function __construct(
        private string $name,
        private bool $notified = false
    ) {}

    public function update(\SplSubject $subject) {
        echo "Nouvelle date";
        $this->notified = true;
    }

    public function isNotified(): bool
    {
        return $this->notified;
    }
}