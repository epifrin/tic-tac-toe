<?php

namespace App\Application;

interface Input
{
    public function askMove(): string;
}
