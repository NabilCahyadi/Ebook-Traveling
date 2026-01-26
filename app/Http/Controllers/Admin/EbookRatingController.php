<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\EbookRating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EbookRatingController extends Controller
{
    /**
     * Display ratings for a specific ebook.
     */
    public function index(string $ebookId)
    {
        $ebook = Ebook::with(['ratings.user'])->findOrFail($ebookId);
        $ratings = EbookRating::where('ebook_id', $ebookId)
            ->with('user')
            ->latest()
            ->paginate(15);

        // Calculate rating statistics
        $stats = [
            'total' => $ratings->total(),
            'average' => $ebook->ratings()->avg('rating') ?? 0,
            'distribution' => [
                5 => $ebook->ratings()->where('rating', 5)->count(),
                4 => $ebook->ratings()->where('rating', 4)->count(),
                3 => $ebook->ratings()->where('rating', 3)->count(),
                2 => $ebook->ratings()->where('rating', 2)->count(),
                1 => $ebook->ratings()->where('rating', 1)->count(),
            ],
        ];

        return view('admin.ebooks.ratings.index', compact('ebook', 'ratings', 'stats'));
    }

    /**
     * Show form to create a new rating for an ebook.
     */
    public function create(string $ebookId)
    {
        $ebook = Ebook::findOrFail($ebookId);
        $users = User::orderBy('name')->get();

        return view('admin.ebooks.ratings.create', compact('ebook', 'users'));
    }

    /**
     * Store a new rating.
     */
    public function store(Request $request, string $ebookId)
    {
        try {
            $ebook = Ebook::findOrFail($ebookId);

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'rating' => 'required|integer|min:1|max:5',
                'review_title' => 'nullable|string|max:255',
                'review_text' => 'nullable|string|max:2000',
            ]);

            // Check if user already rated this ebook
            $existingRating = EbookRating::where('ebook_id', $ebookId)
                ->where('user_id', $validated['user_id'])
                ->first();

            if ($existingRating) {
                return back()->withInput()
                    ->with('error', __('admin.ratings.user_already_rated'));
            }

            $validated['ebook_id'] = $ebookId;
            $validated['is_approved'] = $request->has('is_approved');

            $rating = EbookRating::create($validated);

            // Update ebook average rating
            $this->updateEbookRating($ebook);

            return redirect()->route('admin.ebooks.ratings.index', $ebookId)
                ->with('success', __('admin.ratings.rating_added'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating rating: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('admin.ratings.failed_add') . ': ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit a rating.
     */
    public function edit(string $ebookId, string $ratingId)
    {
        $ebook = Ebook::findOrFail($ebookId);
        $rating = EbookRating::where('ebook_id', $ebookId)->findOrFail($ratingId);
        $users = User::orderBy('name')->get();

        return view('admin.ebooks.ratings.edit', compact('ebook', 'rating', 'users'));
    }

    /**
     * Update a rating.
     */
    public function update(Request $request, string $ebookId, string $ratingId)
    {
        $ebook = Ebook::findOrFail($ebookId);
        $rating = EbookRating::where('ebook_id', $ebookId)->findOrFail($ratingId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:255',
            'review_text' => 'nullable|string|max:2000',
        ]);

        $validated['is_approved'] = $request->has('is_approved');

        $rating->update($validated);

        // Update ebook average rating
        $this->updateEbookRating($ebook);

        return redirect()->route('admin.ebooks.ratings.index', $ebookId)
            ->with('success', __('admin.ratings.rating_updated'));
    }

    /**
     * Delete a rating.
     */
    public function destroy(string $ebookId, string $ratingId)
    {
        $ebook = Ebook::findOrFail($ebookId);
        $rating = EbookRating::where('ebook_id', $ebookId)->findOrFail($ratingId);

        $rating->delete();

        // Update ebook average rating
        $this->updateEbookRating($ebook);

        return redirect()->route('admin.ebooks.ratings.index', $ebookId)
            ->with('success', __('admin.ratings.rating_deleted'));
    }

    /**
     * Toggle approval status of a rating.
     */
    public function toggleApproval(string $ebookId, string $ratingId)
    {
        $ebook = Ebook::findOrFail($ebookId);
        $rating = EbookRating::where('ebook_id', $ebookId)->findOrFail($ratingId);

        $rating->is_approved = !$rating->is_approved;
        $rating->save();

        // Update ebook average rating
        $this->updateEbookRating($ebook);

        return back()->with('success', __('admin.ratings.approval_updated'));
    }

    /**
     * Update ebook's average rating.
     */
    private function updateEbookRating(Ebook $ebook)
    {
        $avgRating = $ebook->ratings()->where('is_approved', true)->avg('rating') ?? 0;

        $ebook->update([
            'average_rating' => round($avgRating, 2),
        ]);
    }
}
