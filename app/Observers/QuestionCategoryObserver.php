<?php

namespace App\Observers;

use App\Models\QuestionCategory;

class QuestionCategoryObserver
{
    /**
     * Handle the QuestionCategory "creating" event.
     *
     * @param  \App\Models\QuestionCategory  $customer
     * @return void
     */
    public function creating(QuestionCategory $questionCategory)
    {
        $questionCategory->slug = str_replace(' ', '_', trim($questionCategory->category));
        return $questionCategory;
    }
}
