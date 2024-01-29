<?php

namespace App\Filters\Admin\EmployeePage;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;
use Session;
use App\Models\DepartmentList;

class DepartmentActiveFilter extends Filter
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
        return 'Department Filter'; // Set the title for the BranchActiveFilter
    }
    public function apply(Builder $query, $value, $request): Builder
    {
        // dd($query);
        return $query->where('depart_name', $value);
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options(): array
    {
        $department = DepartmentList::where('b_id', Session::get('business_id'))->pluck('depart_name', 'depart_name')->toArray();
        // dd($branches);
        return $department;

        // return [];
    }
}
