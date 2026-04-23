<?php

namespace App\Http\Middleware;

use App\Models\Consent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureConsentsAccepted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $privacyVersion = config('consents.privacy_policy.version');
        $termsVersion   = config('consents.terms_conditions.version');

        $accepted = Consent::where('user_id', $user->id)
            ->whereIn('type', ['privacy_policy', 'terms_conditions'])
            ->get()
            ->keyBy('type');

        $hasPrivacy = isset($accepted['privacy_policy'])
            && $accepted['privacy_policy']->version === $privacyVersion;

        $hasTerms = isset($accepted['terms_conditions'])
            && $accepted['terms_conditions']->version === $termsVersion;

        if (! $hasPrivacy || ! $hasTerms) {
            return redirect()->route('consent.show');
        }

        return $next($request);
    }
}
