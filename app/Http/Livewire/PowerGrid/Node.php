<?php

namespace App\Http\Livewire\PowerGrid;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class Node extends PowerGridComponent
{
    use ActionButton;
    public $priceFilter = null; // Initialize as null to differentiate from an empty string
    protected $listeners = ['filterProducts'];

    public function datasource(): ?Collection
    {
        $data = collect([
            ['id' => 1, 'name' => 'jay 1', 'price' => 1.58, 'created_at' => now()],
            ['id' => 2, 'name' => 'Name 2', 'price' => 1.68, 'created_at' => now()],
            ['id' => 3, 'name' => 'Name 3', 'price' => 1.78, 'created_at' => now()],
            ['id' => 4, 'name' => 'Name 4', 'price' => 1.88, 'created_at' => now()],
            ['id' => 5, 'name' => 'Name 5', 'price' => 1.98, 'created_at' => now()],
        ]);

        if ($this->priceFilter !== null) {
            // Convert the entered filter to a float for proper comparison
            $filterPrice = floatval($this->priceFilter);

            // Filter data where price is greater than or equal to the entered filter price
            $data = $data->filter(function ($item) use ($filterPrice) {
                return $item['price'] >= $filterPrice;
            });
        }

        return $data;
    }
    public function filterProducts()
    {
        // This will refresh the data based on the updated filter value
        $this->refresh();
    }
    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('price')
            ->addColumn('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |

    */
    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('Created', 'created_at_formatted'),
        ];
    }
}
