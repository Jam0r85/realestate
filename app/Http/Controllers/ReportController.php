<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementReportRequest;
use App\Statement;
use App\Tenancy;
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

        $tenancies = Tenancy::whereHas('statements', function ($query) use ($request, $from, $until) {
            $query->whereNotNull('paid_at')->where('created_at', '>=', $from)->where('created_at', '<', $until);
        })->with('property','statements')->get();

        foreach ($tenancies as $tenancy) {
            $data[] = [
                'landlords_name' => $tenancy->landlord_name,
                'landlord_address' => $tenancy->landlord_address ? $tenancy->landlord_address->name_without_postcode : null,
                'postcode' => $tenancy->landlord_address ? $tenancy->landlord_address->postcode : null,
                'currency_code' => 'GBP',
                'total_gross' => $tenancy->statements->sum('landlord_balance_amount'),
                'let_address' => $tenancy->property->name_without_postcode,
                'let_address_postcode' => $tenancy->property->postcode,
                'tax_year' => $from->format('Y') . '/' . $until->format('Y'),
                'company_name' => get_setting('company_name')
            ];
        }

        $this->exportToCsv([
            'file_name' => 'Statements Created',
            'data' => $data
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
                $sheet->setColumnFormat(array(
                    'E' => '[$£]#,##0.00_-'
                ));
                $sheet->fromArray($data['data']);
            });
        })->export('xls');
    }
}
