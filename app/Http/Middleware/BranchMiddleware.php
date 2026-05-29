<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BranchMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('active_branch_id')) {
            $defaultBranch = \App\Models\Branch::where('slug', 'sinza')->first();
            if ($defaultBranch) {
                session(['active_branch_id' => $defaultBranch->id]);
                session(['active_branch_name' => $defaultBranch->name]);
                session(['active_branch_slug' => $defaultBranch->slug]);
            }
        }

        // Share branches with all views
        view()->share('all_branches', \App\Models\Branch::where('is_active', true)->get());

        return $next($request);
    }
}
