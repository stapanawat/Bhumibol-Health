<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        // Force use of twitter-oauth-2 driver if provider is twitter
        $driver = $provider === 'twitter' ? 'twitter-oauth-2' : $provider;

        $clientId = config("services.$driver.client_id");
        $clientSecret = config("services.$driver.client_secret");

        if (empty($clientId) || empty($clientSecret)) {
            return response()->json([
                'error' => 'Configuration Missing',
                'message' => "The client_id or client_secret for '$driver' is empty.",
                'hint' => "Please check your .env file and ensure ${provider}_CLIENT_ID and ${provider}_CLIENT_SECRET are set.",
                'debug_config' => config("services.$driver")
            ], 500);
        }

        return Socialite::driver($driver)->redirect();
    }

    public function callback($provider)
    {
        // Force use of twitter-oauth-2 driver if provider is twitter
        $driver = $provider === 'twitter' ? 'twitter-oauth-2' : $provider;

        try {
            $socialUser = Socialite::driver($driver)->user();

            // Check if user exists by explicit provider ID (oauth 1 or 2)
            $user = User::where($provider . '_id', $socialUser->getId())
                ->orWhere('twitter_id', $socialUser->getId()) // Check specifically for twitter_id just in case
                ->orWhere('email', $socialUser->getEmail())
                ->first();

            if ($user) {
                // Update existing user with provider ID if not set
                if (!$user->{$provider . '_id'}) {
                    $user->update([
                        $provider . '_id' => $socialUser->getId(),
                        'avatar' => $socialUser->getAvatar() ?? $user->avatar,
                    ]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(), // Twitter sometimes only returns nickname
                    'email' => $socialUser->getEmail() ?? $socialUser->getId() . '@' . $provider . '.com', // Fallback if no email
                    'password' => bcrypt(str()->random(16)),
                    $provider . '_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }

            Auth::login($user);

            return redirect()->route('home');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Social login session expired. Please try again.');
        } catch (\League\OAuth1\Client\Credentials\CredentialsException $e) {
            // Specific handling for Twitter OAuth 1.0a credentials error
            return response()->json([
                'error' => 'Twitter Authentication Failed',
                'message' => 'Could not authenticate with Twitter.',
                'detail' => $e->getMessage(),
                'hint' => 'For standard Twitter login, ensure you are using the "API Key" and "API Key Secret" from the Twitter Developer Portal, NOT the "OAuth 2.0 Client ID". check your .env file.',
            ], 500);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to login with ' . ucfirst($provider) . '. Error: ' . $e->getMessage());
        }
    }
}
