<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contact::select('id', 'name', 'email', 'subject', 'message', 'is_read', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Optional: Set headings in Excel
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Subject',
            'Message',
            'Is Read',
            'Created At',
        ];
    }
}
