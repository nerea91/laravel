<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\HtmlBuilder;
use App\Builders\FormBuilder;

class FormServiceProvider extends ServiceProvider
{
	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function register()
	{
		// Bind 'html' shared component to the IoC container
        $this->app->singleton('html', function ($app) {
            return new HtmlBuilder($app['url'], $app['view']);
        });

		// Bind 'form' shared component to the IoC container
		$this->app->singleton('form', function ($app) {

			$form = new FormBuilder(
				$app['html'],
				$app['url'],
				$app['session.store']->token(),
				$app['translator'],
				$app['session.store']->get('errors')
			);

			return $form->setSessionStore($app['session.store']);
		});

        $this->app->singleton('form', function ($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->token(), $app['translator'], $app['session.store']->get('errors'));

            return $form->setSessionStore($app['session.store']);
        });

        $this->app->alias('html', 'Collective\Html\HtmlBuilder');
        $this->app->alias('form', 'Collective\Html\FormBuilder');
	}

}
