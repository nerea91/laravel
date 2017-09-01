<?php
namespace App\Jobs;
use App\Jobs\Job;
use App\Language;
use Request;
class SetLocale extends Job
{
    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if(!session()->has('locale'))
        {
            session()->put('locale', Request::getPreferredLanguage( config('app.languages') ));
        }
        app()->setLocale(session('locale'));
        $language = Language::where('code', session('locale'))->first();
        session()->put('language', $language);

        if($language)
            $language->apply();
    }
}
