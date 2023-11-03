<?php

namespace App\Http\Middleware;

use App\Tbuy\Locale\Models\Locale;
use App\Tbuy\Locale\Repositories\LocaleRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function __construct(private readonly LocaleRepository $localeRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $localesList = $this->localeRepository->get();
        $lang = $request->headers->get('lang');

        /** @var Locale|null $locale */
        $locale = $localesList->where('locale', $lang)->first() ?: $localesList->where('is_main', true)->first();


        app()->setLocale($locale->locale);

        return $next($request);
    }
}
