<?php

namespace App\Http\Controllers;

use App\Document;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('expense_id')) {
            $parent = Expense::findOrFail($request->expense_id);
        }

        foreach ($request->file('files') as $file) {
            $parent->storeDocument($file);
        }

        $this->successMessage('The ' . str_plural($parent->getDocumentNameType(), count($request->files)) . ' ' . str_plural('was', count($request->files)) . ' uploaded');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $document = Document::findOrFail($id);
        return view('documents.show.' . $section, compact('document'));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $document->name = $request->name;
        $document->save();

        $this->successMessage('The document "' . $document->name . '" was updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
