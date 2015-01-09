<?php namespace App\Http\Controllers;

use App\Exceptions\AccessControlListException;
use App\Document;
use Auth;

class DocumentController
{
	/**
	 * Show main page
	 *
	 * @param  integer
	 * @return Response
	 * @throws App\Exceptions\AccessControlListException;
	 */
	public function show($documentId, $notUsed = null)
	{
		// Check if document exist
		$document = Document::findOrFail($documentId);

		// Check if user profile has permission to see this document
		if( ! Auth::user()->profile->hasDocument($document))
			throw new AccessControlListException(_('Unauthorized profile'));



		// Render document
		return view('document', [
			'title' => $document->title,
			'body'  => markdown($document->body),
			'documents' => Auth::user()->profile->getDocuments()
		]);
	}
}
