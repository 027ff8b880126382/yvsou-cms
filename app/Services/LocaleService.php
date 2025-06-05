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


namespace App\Services;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LocaleService
{

    public function setLocaleFromCookie(): string
    {
        // $cookieLocale = request()->cookie('locale', config('app.locale'));
        //  $cookieLocale = request()->cookie('locale', config(key: 'site.DEFAULT_LANGUAGE'));
        $cookieLocale = Cookie::get('locale', config(key: 'yvsou_config.DEFAULT_LANGUAGE'));
        logger('cookieLocale', [$cookieLocale]); // Temporarily check this

        if (!in_array($cookieLocale, config('yvsou_config.LANGUAGESET'))) {
            logger('cookieLocale in not in langset   ', [$cookieLocale]); // Temporarily check this
            logger('LANGUAGESET in not in langset   ', [config('yvsou_config.LANGUAGESET')]); // Temporarily check this

            $cookieLocale = App::getLocale();
        } else {
            if (App::getLocale() !== $cookieLocale) {
                App::setLocale($cookieLocale);
                logger('setLocale', [$cookieLocale]); // Temporarily check this
                logger('setLocaleafter', [App::getLocale()]); // Temporarily check this
                return redirect()->back();
            }
        }
        return '1';
    }
    public function getlangSet($langSet): array
    {
        $languageArray = [];
        foreach ($langSet as $code) {

            $code = trim($code);

            $languageArray[$code] = ConstantService::LANGUAGE_CONFIG[$code]['native'];

        }
        return $languageArray;
    }

    public function getlangIdSet(): array
    {
        $langidArray = [];
        $langset = config('yvsou_config.LANGUAGESET', []);
        foreach ($langset as $code) {

            $langid = $this->getlangID($code);
            $language = ConstantService::LANGUAGE_CONFIG[$code]['native'];
            $langidArray[] = ['langid' => $langid, 'language' => $language];
        }
        return $langidArray;
    }

    public function getlangID($code): int
    {

        return ConstantService::LANGUAGE_CONFIG[$code]['id'];

    }



    public function getSetLocaleFromCookie(): void
    {

        $cookieLocale = Cookie::get('locale');

        if (!in_array($cookieLocale, config('yvsou_config.LANGUAGESET'))) {

        } else {
            if (App::getLocale() !== $cookieLocale) {
                App::setLocale($cookieLocale);
                logger('setLocale', [$cookieLocale]); // Temporarily check this
                logger('setLocaleafter', [App::getLocale()]); // Temporarily check this
            }
        }

    }

    public function getcurlang(): int
    {
        $this->getSetLocaleFromCookie();
        $code = App::getLocale();
        $langid = $this->getlangID($code);
        logger('langcode, langid ', [$code, $langid]);
        return $langid;

    }


}






