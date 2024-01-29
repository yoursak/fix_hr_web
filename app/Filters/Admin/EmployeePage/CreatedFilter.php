<?php

namespace App\Filters\Admin\EmployeePage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\DateFilter;

class CreatedFilter extends DateFilter
{
    /**
     * Modify the current query when the filter is used
     *
     * @param Builder $query Current query
     * @param Carbon $date Carbon instance with the date selected
     * @return Builder Query modified
     */
    public function apply(Builder $query, Carbon $date, $request): Builder
    {
        $formattedDate = $date->format('Y-m-d'); // Adjust the format as needed

        return $query->where('employee_personal_details.emp_date_of_joining', $formattedDate);

    }
}
