<?php
/**
 * © 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo   All rights reserved.
 * Author: Lican Huang
 * License: Dual Licensed – GPLv3 or Commercial
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * As an alternative to GPLv3, commercial licensing is available for organizations
 * or individuals requiring proprietary usage, private modifications, or support.
 *
 * Contact: yvsoucom@gmail.com
 * GPL License: https://www.gnu.org/licenses/gpl-3.0.html
 */


namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;



class SetLocale
{
    public function handle1($request, Closure $next)
    {

        $cookieLocale = $request->cookie('locale'); // Already decrypted
    


        //  $cookieLocale = Cookie::get('locale', config(key: 'site.DEFAULT_LANGUAGE'));
        // $cookieLocale = Cookie::get('locale', config(key: 'site.DEFAULT_LANGUAGE'));

        logger('cookieLocale in SetLocaleFromCookie class ', [$cookieLocale]); // Temporarily check this

        if (!in_array($cookieLocale, config('yvsou_config.LANGUAGESET'))) {
            logger('cookieLocale in not in langset   ', [$cookieLocale]); // Temporarily check this
         //   Cookie::queue(Cookie::forget('locale'));
        } else {
            logger('setLocalebefore getlocale', [App::getLocale()]); // Temporarily check this
            if (App::getLocale() !== $cookieLocale) {
                logger('setLocalebefore', [App::getLocale()]); // Temporarily check this
                App::setLocale($cookieLocale);

                logger('setLocaleafter', [App::getLocale()]); // Temporarily check this
            }
        }

        return $next($request);
    }

   
    public function handle($request, Closure $next)
    {
        // Automatically decrypted by EncryptCookies middleware
        $cookieLocale = $request->cookie('locale');

        logger('cookieLocale in SetLocale middleware', [$cookieLocale]);

        $availableLocales = config('yvsou_config.LANGUAGESET');

        if (in_array($cookieLocale, $availableLocales)) {
            if (App::getLocale() !== $cookieLocale) {
                logger('Setting locale from cookie', ['from' => App::getLocale(), 'to' => $cookieLocale]);
                App::setLocale($cookieLocale);
            }
        } else {
            logger('Invalid locale found in cookie', [$cookieLocale]);
            // Optional: unset bad cookie
            // Cookie::queue(Cookie::forget('locale'));
        }

        return $next($request);
    }
}

 
class SetLocale1
{
    public function handle($request, Closure $next)
    {
        $locale = Cookie::get('locale', config('app.locale'));
        $availableLocales = array_keys(config('yvsou_config.LANGUAGESET'));

        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}



