<?php

namespace App;

use Barryvdh\DomPDF\Facade as PDF;

class PdfModel extends FileModel
{
	/**
	 * The view folder where the PDF templates are located.
	 * 
	 * @var  string
	 */
	protected $pdfTemplates = 'pdf';

	/**
	 * Get the view name for this PDF template.
	 * 
	 * @return  string
	 */
	public function viewName()
	{
		return $this->pdfTemplates . '.' . $this->classNameSingular();
	}

	/**
	 * Stream the PDF to the browser.
	 * 
	 * @return  \Illuminate\Http\Response
	 */
	public function streamPdf()
	{
		return $this->createPdf('stream');
	}

	/**
	 * Download the PDF as a file.
	 * 
	 * @return  \Illuminate\Http\Response
	 */
	public function downloadPdf()
	{
		return $this->createPdf('download');
	}

	/**
	 * Create the PDF and return it.
	 *
	 * @param  string  $return
	 * @return [type]
	 */
	public function createPdf($return, $fileName = null)
	{
		$title = $this->classNameSingular() . '-' . $this->id . '.pdf';

		return PDF::loadView($this->viewName(), [
            $this->classNameSingular() => $this,
            'title' => $title
        ])->$return($title);
	}
}