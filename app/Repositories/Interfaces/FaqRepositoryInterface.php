<?php

// app/Repositories/Interfaces/FaqRepositoryInterface.php

namespace App\Repositories\Interfaces;

interface FaqRepositoryInterface
{
    public function getActiveByCategory(string $category);
}
