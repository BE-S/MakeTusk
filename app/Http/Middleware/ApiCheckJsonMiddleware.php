<?php

namespace App\Http\Middleware;

use App\Traits\ResponseApi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiCheckJsonMiddleware
{
    use ResponseApi;

    /**
     * Проверить заголовки пользователя на предмет JSON
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isJson() && !$request->wantsJson()) {
            return $this->error("Json only!");
        }

        return $next($request);
    }
}
