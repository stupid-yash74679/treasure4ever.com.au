<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Statamic\Facades\AssetContainer;

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);
Route::get('/csrf-token', function () {
    return response()
        ->json(['token' => csrf_token()])
        ->withCookie(cookie('XSRF-TOKEN', csrf_token(), 60, '/', null, false, false));
});

Route::middleware(['web', VerifyCsrfToken::class])->post('/add-blog', function (Request $request) {
    $csrfTokenFromHeader = $request->header('X-XSRF-TOKEN');

    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'content' => 'nullable|string',
        'alt_seo_nofollow' => 'boolean',
        'alt_seo_noindex' => 'boolean',
        'alt_seo_meta_description' => 'nullable|string',
        'alt_seo_meta_title' => 'nullable|string',
        'alt_seo_social_description' => 'nullable|string',
        'alt_seo_social_title' => 'nullable|string',
        'author' => 'required|string',
        'updated_by' => 'required|string',
        'exclude_from_sitemap' => 'boolean',
        'protect' => 'string|in:none,password,login',
        'page_code.code' => 'required|string',
        'page_code.mode' => 'required|string'
    ]);

    try {
        $entry = Entry::make()
            ->collection('blogs');

        if (!$entry->collection()) {
            return response()->json(['error' => 'Collection not found.'], 500);
        }

        $entry->slug($request->slug)
            ->data([
                'title' => $request->title,
                'alt_seo_nofollow' => $request->alt_seo_nofollow ?? false,
                'alt_seo_noindex' => $request->alt_seo_noindex ?? false,
                'alt_seo_meta_description' => $request->input('alt_seo_meta_description'),
                'alt_seo_meta_title' => $request->input('alt_seo_meta_title'),
                'alt_seo_social_description' => $request->input('alt_seo_social_description'),
                'alt_seo_social_title' => $request->input('alt_seo_social_title'),
                'author' => $request->author,
                'updated_by' => $request->updated_by,
                'exclude_from_sitemap' => $request->exclude_from_sitemap ?? false,
                'protect' => $request->protect ?? 'none',
                'content' => $request->content ?? '',
                'page_code' => [
                    'code' => $request->input('page_code.code'),
                    'mode' => $request->input('page_code.mode')
                ]
            ])
            ->published(true);

        $entry->save();

        return response()->json([
            'message' => 'Product created successfully',
            'url' => $entry->absoluteUrl(),
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Server error.'], 500);
    }
});

Route::middleware(['web'])->get('/get-blogs', function () {
    $blogs = \Statamic\Facades\Entry::query()
        ->where('collection', 'blogs')
        ->get()
        ->map(function ($entry) {
            return [
                'id' => $entry->id(),
                'title' => $entry->get('title'),
                'content' => $entry->get('content'),
                'slug' => $entry->slug(),
                'url' => $entry->absoluteUrl(),
                'image_url' => $entry->get('image_url'),
                'thumbnail_image_url' => $entry->get('thumbnail_image_url'),
            ];
        });

    return response()->json($blogs);
});

Route::middleware(['web', VerifyCsrfToken::class])->post('/update-blog-image', function (Request $request) {
    $request->validate([
        'id' => 'required|string',
        'image_url' => 'nullable|url',
        'thumbnail_image_url' => 'nullable|url'
    ]);

    try {
        $entry = \Statamic\Facades\Entry::find($request->id);

        if (!$entry) {
            return response()->json(['error' => 'Entry not found'], 404);
        }

        $container = AssetContainer::find('assets');

        if ($request->image_url) {
            $imageContent = file_get_contents($request->image_url);
            $imageName = 'image_' . uniqid() . '.' . pathinfo(parse_url($request->image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
            $path = 'uploads/' . $imageName;
            $container->disk()->put($path, $imageContent);
            $asset = $container->makeAsset($path);
            $asset->save();
            $entry->set('image_url', $asset->url());
        }

        if ($request->thumbnail_image_url) {
            $thumbContent = file_get_contents($request->thumbnail_image_url);
            $thumbName = 'thumb_' . uniqid() . '.' . pathinfo(parse_url($request->thumbnail_image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
            $path = 'uploads/' . $thumbName;
            $container->disk()->put($path, $thumbContent);
            $asset = $container->makeAsset($path);
            $asset->save();
            $entry->set('thumbnail_image_url', $asset->url());
        }

        $entry->save();

        return response()->json(['message' => 'Blog image updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Server error.'], 500);
    }
});
