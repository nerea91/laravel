<?php namespace App\Http\Controllers;

use App\Document;
use App\Exceptions\AccessControlListException;
use Auth;
use Illuminate\Routing\Controller as BaseController;

class DocumentController extends BaseController
{
	/**
	 * Show main page
	 *
	 * @param  integer
	 * @param  string   $notUsed  Title
	 *
	 * @return Response
	 * @throws App\Exceptions\AccessControlListException;
	 */
	public function show($documentId, $notUsed = null)
	{
		// Check if document exist
		$document = Document::findOrFail($documentId);

		// Check if user profile has permission to see this document
		if( ! Auth::user()->profile->hasDocument($document))
			throw new AccessControlListException(_('Unauthorized profile'), 401);

		// Render document
		return view('document', [
			'title'     => $document->title,
			'body'      => markdown($document->body),
			'documents' => Auth::user()->profile->getDocuments(),
		]);
	}
}
