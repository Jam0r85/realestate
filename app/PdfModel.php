<?php

namespace App;

use Barryvdh\DomPDF\Facade as PDF;

class PdfModel extends FileModel
{
	/**
	 * The view folder where the PDF templates are located.
	 * 
	 * @var string
	 */
	protected $pdfTemplates = 'pdf';

	/**
	 * Get the view name for this PDF template.
	 * 
	 * @return string
	 */
	public function viewName()
	{
		return $this->pdfTemplates . '.' . $this->classNameSingular();
	}

	/**
	 * Create the PDF and return it.
	 *
	 * @param  string $return
	 * @return [type]
	 */
	public function createPdf($return = 'stream')
	{
		return PDF::loadView($this->viewName(), [
            $this->classNameSingular() => $this,
            'title' => $this->classNameSingular() . '-' . $this->id
        ])->$return();
	}
}