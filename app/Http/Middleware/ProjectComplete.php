<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProjectComplete
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
        $project = $request->route('project');
        
        if (!$project || !$project->is_complete) {
            return redirect()->back()->withErrors([
                'rating' => 'You can only rate freelancers after project completion'
            ]);
        }

        return $next($request);
    }
}