<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class RedirectFromOldSlug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $url = parse_url($request->url(), PHP_URL_PATH);
        $redirect = Redirect::query()
            ->where('old_slug', $url)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        $slug = null;
        while ($redirect !== null)
        {
            $slug = $redirect->new_slug;
            $redirect = Redirect::query()
                ->where('old_slug', $slug)
                ->where('created_at', '>', $redirect->created_at)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->first();
        }
        if ($slug !== null) {
            return redirect($slug);
        }

        return $next($request);
    }
}
