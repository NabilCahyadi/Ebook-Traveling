<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubscriptionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = Subscription::query()->with(['user', 'admin']);

        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['subscription_type'])) {
            $query->where('subscription_type', $this->filters['subscription_type']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('start_date', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('end_date', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'User Email',
            'Subscription Type',
            'Status',
            'Start Date',
            'End Date',
            'Price',
            'Payment Method',
            'Created By',
            'Created At',
        ];
    }

    public function map($subscription): array
    {
        return [
            $subscription->id,
            $subscription->user?->name ?? '-',
            $subscription->user?->email ?? '-',
            ucfirst($subscription->subscription_type),
            ucfirst($subscription->status),
            $subscription->start_date?->format('Y-m-d') ?? '-',
            $subscription->end_date?->format('Y-m-d') ?? '-',
            $subscription->price ? 'Rp ' . number_format($subscription->price, 0, ',', '.') : '-',
            $subscription->payment_method ? ucfirst($subscription->payment_method) : '-',
            $subscription->admin?->name ?? 'System',
            $subscription->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
