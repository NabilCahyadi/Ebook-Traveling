<?php

namespace App\Exports;

use App\Models\Ebook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EbooksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = Ebook::query()
            ->with(['creator', 'categories'])
            ->withCount('ratings')
            ->withAvg('ratings', 'rating');

        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['category_id'])) {
            $query->whereHas('categories', function ($q) {
                $q->where('categories.id', $this->filters['category_id']);
            });
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
            'Title',
            'Author',
            'Publisher',
            'ISBN',
            'Categories',
            'Pages',
            'File Size (MB)',
            'Average Rating',
            'Total Ratings',
            'Total Views',
            'Status',
            'Created By',
            'Upload Date',
        ];
    }

    public function map($ebook): array
    {
        return [
            $ebook->id,
            $ebook->title,
            $ebook->author ?? '-',
            $ebook->publisher ?? '-',
            $ebook->isbn ?? '-',
            $ebook->categories->pluck('name')->join(', '),
            $ebook->pages ?? '-',
            $ebook->file_size ? round($ebook->file_size / 1024 / 1024, 2) : '-',
            $ebook->ratings_avg_rating ? round($ebook->ratings_avg_rating, 1) : 'N/A',
            $ebook->ratings_count ?? 0,
            $ebook->total_views ?? 0,
            $ebook->is_active ? 'Active' : 'Inactive',
            $ebook->creator?->name ?? 'System',
            $ebook->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
