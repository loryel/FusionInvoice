<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Users\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Register the view path
		$viewPaths = \Config::get('view.paths');
		$viewPaths[] = __DIR__ . '/../Views';
		\Config::set('view.paths', $viewPaths);
	}

	public function register()
	{
        $this->app->bind('UserRepository', 'FI\Modules\Users\Repositories\UserRepository');
        $this->app->bind('UserValidator', 'FI\Modules\Users\Validators\UserValidator');

        $this->app->bind('UserController', function($app)
        {
            return new \FI\Modules\Users\Controllers\UserController(
                $app->make('UserRepository'),
                $app->make('UserValidator')
            );
        });
	}

}