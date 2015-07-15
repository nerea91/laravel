<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;
use Response;

class LogViewerController extends \Illuminate\Routing\Controller
{
	/**
	 * Show logs only if current environment is local or the current authenticated user is the superuser.
	 *
	 * @param  Request  $request
	 *
	 * @return Response
	 */
	public function showLogs(Request $request)
	{
		// Check permissions
		$isSuperUser = $request->user() and $request->user()->id === 1;
		if( ! app()->environment('local') and ! $isSuperUser)
			abort(404);

		// Check parameters
		if($request->input('l'))
			LaravelLogViewer::setFile(base64_decode($request->input('l')));

		if($request->input('dl'))
			return Response::download(storage_path() . '/logs/' . base64_decode($request->input('dl')));

		return view('logs', [
			'title' => 'Logs',
			'logs' => LaravelLogViewer::all(),
			'files' => LaravelLogViewer::getFiles(true),
			'current_file' => LaravelLogViewer::getFileName()
		]);
	}
}
