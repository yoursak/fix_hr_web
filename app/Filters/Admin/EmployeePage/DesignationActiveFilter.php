<?php

namespace App\Filters\Admin\EmployeePage;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;
use App\Models\DesignationList;
use Session;

class DesignationActiveFilter extends Filter
{
    /**
     * Modify the current query when the filter is used
     *
     * @param Builder $query Current query
     * @param $value Value selected by the user
     * @return Builder Query modified
     */
    public function getTitle(): string
    {
        return 'Desgination Filter'; // Set the title for the BranchActiveFilter
    }

    public function apply(Builder $query, $value, $request): Builder
    {
        return $query->where('desig_name', $value);
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options(): array
    {
        $branches = DesignationList::where('business_id', Session::get('business_id'))->pluck('desig_name', 'desig_name')->toArray();
        // dd($branches);
        return $branches;
    }
}
