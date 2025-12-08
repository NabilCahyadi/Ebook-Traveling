<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class RatingStars extends Component
{
    /**
     * The rating value.
     *
     * @var int
     */
    public $rating;

    /**
     * Create the component instance.
     *
     * @param int $rating
     * @return void
     */
    public function __construct($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.ratings.rating-stars');
    }
}
