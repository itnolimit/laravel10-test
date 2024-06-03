<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Prime\Vehicle\Models\Vehicle;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

#[Lazy]
class VehicleTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPerPage(perPage: 25)
            ->setThAttributes(fn (Column $column) => $column->getTitle() === 'Action' ? ['width' => '50'] : []);
    }

    public function columns(): array
    {
        return [
            Column::make('Unit No.', 'unit_number')
                ->format(
                    fn ($value, $row, Column $column) => '<a href="'.route('vehicle.show', [$row->id]).'" class="text-primary" >'.$row->unit_number.'<a/>'
                )
                ->html()->searchable(),
            Column::make('Year', 'year')->sortable()->searchable(),
            Column::make('Make', 'make')->sortable()->searchable(),
            Column::make('Model', 'model')->sortable()->searchable(),
            Column::make('Vin', 'vin')->sortable()->searchable(),
            Column::make('Plate No.', 'plate_number')->format(fn ($value, $row, Column $column) => view('vehicle::components.vehicle.tables.includes.plate-number', compact('row')))->sortable()->searchable(),
            Column::make('State', 'state')->sortable()->searchable(),
        ];
    }

    public function builder(): Builder
    {
        $vehicles = Vehicle::query()->select('vehicles.*')
            ->Company(1);

        return $vehicles->with(['plates'])->withTrashed();
    }
}
