<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DocumentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Document';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = $this->repository
            ->with('parent')
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('documents.index', compact('documents'));
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

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $document = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('documents.show', compact('document','show'));     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('documents.edit', compact('document'));
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
        $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Upload and store a new document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $document = $this->repository
            ->findOrFail($id);

        // Destroy the existing file.
        if (Storage::exists($document->path)) {
            Storage::delete($document->path);
            flash_message('The existing file was destroyed');
        }

        if ($request->hasFile('file')) {
            if ($new_path = $request->file('file')->store(dirname($document->path))) {
                $document->update(['path' => $new_path]);
                flash_message('The new file was uploaded');
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        parent::destroy($request, $id);
        return back();
    }

    /**
     * Destroy a record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Request $request, $id)
    {
        $document = parent::forceDestroy($request, $id);

        if (Storage::exists($document->path)) {
            Storage::delete($document->path);
        }

        return redirect()->route($this->indexView);
    }
}
