<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = User::query()->with(['city', 'subscriptions']);

        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['city_id'])) {
            $query->where('city_id', $this->filters['city_id']);
        }

        if (isset($this->filters['is_active'])) {
            $query->where('is_active', $this->filters['is_active']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'City',
            'Gender',
            'Status',
            'Email Verified',
            'Active Subscription',
            'Registered Date',
            'Last Login'
        ];
    }

    public function map($user): array
    {
        $activeSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone ?? '-',
            $user->city?->name ?? '-',
            $user->gender ? ucfirst($user->gender) : '-',
            $user->is_active ? 'Active' : 'Inactive',
            $user->email_verified_at ? 'Yes' : 'No',
            $activeSubscription ? $activeSubscription->subscription_type : 'No Subscription',
            $user->created_at->format('Y-m-d H:i:s'),
            $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
