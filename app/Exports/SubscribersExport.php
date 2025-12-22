<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscribersExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(private Builder $query) {}

    public function query()
    {
        return $this->query->with('topics');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Email',
            'Name',
            'Status',
            'Verified At',
            'Topics',
            'Created At',
        ];
    }

    public function map($subscriber): array
    {
        return [
            $subscriber->id,
            $subscriber->email,
            $subscriber->name,
            $subscriber->status,
            $subscriber->verified_at?->format('Y-m-d H:i:s'),
            $subscriber->topics->pluck('name')->join(', '),
            $subscriber->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
