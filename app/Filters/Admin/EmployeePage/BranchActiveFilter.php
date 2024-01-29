<?php

namespace App\Filters\Admin\EmployeePage;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;
use Session;
use App\Models\BranchList;

class BranchActiveFilter extends Filter
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
        return 'Branch Filter'; // Set the title for the BranchActiveFilter
    }
    
    public function apply(Builder $query, $value, $request): Builder
    {
        return $query->where('branch_name', $value);
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options(): array
    {
        $branches = BranchList::where('business_id', Session::get('business_id'))->pluck('branch_name', 'branch_name')->toArray();
        // dd($branches);
        return $branches;
        //     [
        //         $branches
        //     ];
    }
}
