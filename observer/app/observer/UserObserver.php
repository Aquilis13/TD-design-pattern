<?php

namespace App\observer;

interface UserObserver extends \SplObserver{

    public function update(\SplSubject $subject);
}