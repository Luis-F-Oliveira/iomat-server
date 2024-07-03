<?php

namespace App\Exports;

use App\Models\CollectedData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollectedDataExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return CollectedData::whereIn('id', $this->ids)
            ->with('servant')
            ->get();
    }

    public function map($data): array
    {
        return [
            $data->order,
            $data->url,
            $data->servant->name,
            $data->servant->email,
            $data->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'Portaria',
            'Url',
            'Nome',
            'Email',
            'Data'
        ];
    }
}
