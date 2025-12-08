{{-- resources/views/components/blogs/blog-tags.blade.php --}}

@props(['blog'])
@if(isset($blog) && $blog->tags && count($blog->tags) > 0)
<div class="entry-bottom mt-50 mb-30">
    {{-- GANTI KELAS DI SINI --}}
    <div class="d-flex flex-wrap align-items-center">
        @foreach($blog->tags as $tag)
        {{-- TAMBAHKAN KELAS MARGIN BAWAH DI SINI --}}
        <a href="{{ route('blogs.by.tag', ['tag' => $tag]) }}" rel="tag" class="hover-up btn btn-sm btn-rounded me-2 mb-2">
            {{ $tag }}
        </a>
        @endforeach
    </div>
</div>
@endif