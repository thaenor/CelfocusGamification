<?php namespace App\Http\Middleware;

use App\Http\Controllers\TicketController;
use Closure;

class AdminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if ($request->user()->id != 0)
        {
            return redirect('home');
        }

		return $next($request);
	}

}
