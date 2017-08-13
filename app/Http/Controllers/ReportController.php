<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementReportRequest;
use App\Statement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @param   EloquentUsersRepository $users
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the reports index page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('reports.index');
    }

    /**
     * Display a listing of the statements created.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function statementsCreated(StatementReportRequest $request)
    {

    	$from = Carbon::createFromFormat('Y-m-d', $request->from);
        $until = $request->until ? Carbon::createFromFormat('Y-m-d', $request->until) : Carbon::now();
    	$statements = Statement::whereNotNull('sent_at')->where('created_at', '>=', $from)->where('created_at', '<', $until)->get();

        $this->exportToCsv([
            'file_name' => 'Statements Created',
            'model' => $statements
        ]);
    }

    /**
     * Export the results to a CSV document.
     * 
     * @param array $data
     * @return void
     */
    protected function exportToCsv(array $data)
    {
        Excel::create($data['file_name'], function($excel) use($data) {
            $excel->sheet($data['file_name'], function($sheet) use($data) {
                $sheet->fromArray($data['model']);
            });
        })->export('xls');
    }
}
