<?php namespace App\Console\Commands;

use App\User;
use Auth;
use Hash;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class SetupSuperUserCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup:superuser';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup superuser password';

	/**
	 * Superuser
	 *
	 * @var User
	 */
	protected $superuser;

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		try
		{
			// Get superuser object
			$this->superuser = User::findOrFail(1);

			// If current password is not the default one ask for it to confirm credentials
			if( ! Hash::check('secret', $this->superuser->password) and ! $this->checkCurrentPassword())
				throw new Exception('Wrong current password');

			$this->askNewPassword();
		}
		catch(ModelNotFoundException $e)
		{
			return $this->error('Superuser not found. Did you seed the database?.');
		}
		catch(Exception $e)
		{
			return $this->error($e->getMessage());
		}

		// Update password
		if($this->superuser->save())
			$this->info('Superuser password set correctly');
		else
			$this->showValidationErrors();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['superuser', InputArgument::OPTIONAL, 'Update superuser password'],
		];
	}

	/**
	 * Ask for new superuser password with confirmation
	 *
	 * @param  integer $attemps Max number of attemps
	 *
	 * @return bool
	 */
	protected function askNewPassword($attemps = 3)
	{
		if($attemps-- <= 0)
			throw new Exception('Max number of attemps exceeded');

		$this->superuser->password = $this->secret('Enter NEW superuser password: ');
		$this->superuser->password_confirmation = $this->secret('Enter NEW superuser password again: ');

		if($this->superuser->validate())
			return true;

		$this->showValidationErrors();

		return $this->askNewPassword($attemps);
	}

	/**
	 * Check current superuser password
	 *
	 * @return bool
	 */
	protected function checkCurrentPassword()
	{
		$credentials = [
			$this->superuser->getKeyName() => $this->superuser->getKey(),
			'password' => $this->secret('Enter superuser CURRENT password: ')
		];

		return Auth::validate($credentials);
	}

	/**
	 * Function description
	 *
	 * @return void
	 */
	public function showValidationErrors()
	{
		foreach($this->superuser->getErrors()->all() as $e)
			$this->error($e);
	}
}
