<?php

namespace App\Http\Controllers;

use App\Http\Requests\LandlordsIncomeRequest;
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
    public function landlordsIncome(LandlordsIncomeRequest $request)
    {
        // Set the from date.
        if ($request->has('from') && !empty($request->from)) {
            $from_date = Carbon::createFromFormat('Y-m-d', $request->from);
        } else {
            $from_date = Statement::oldest()->first()->created_at;
        }

        // Set the until date.
        if ($request->has('until') && !empty($request->until)) {
            $until_date = Carbon::createFromFormat('Y-m-d', $request->until);
        } else {
            $until_date = Statement::latest()->first()->created_at;
        }

        // Grab all of the tenancies.
        $tenancies = Tenancy::all();

        // Create a results array.
        $results = [];

        // Loop through the tenancies.
        foreach ($tenancies as $tenancy) {
            $statements = $tenancy->statements()
                ->where('created_at', '>=', $from_date)
                ->where('created_at', '<', $until_date)
                ->whereNotNull('paid_at')
                ->get();

            if (count($statements)) {
                $results[] = [
                    'landlords_name' => $tenancy->landlord_name,
                    'landlord_address' => $tenancy->landlord_address ? $tenancy->landlord_address->name_without_postcode : null,
                    'postcode' => $tenancy->landlord_address ? $tenancy->landlord_address->postcode : null,
                    'currency_code' => 'GBP',
                    'total_gross' => $tenancy->statements->sum('amount'),
                    'let_address' => $tenancy->property->name_without_postcode,
                    'let_address_postcode' => $tenancy->property->postcode,
                    'tax_year' => $from_date->format('Y') . '/' . $until_date->format('Y'),
                    'company_name' => get_setting('company_name')
                ];
            }
        }

        // Re-arrange the values by landlords name.
        $results = array_values(array_sort($results, function ($value) {
            return $value['landlords_name'];
        }));
        
        // Set the column formatting.
        $column_formatting = [
            'E' => '[$£]#,##0.00_-'
        ];

        // Manipulate the required rows.
        $row_manip = [
            '1' => [
                'Landlords\'s Name',
                'Landlord\'s Address',
                'Postcode',
                'Currency Code',
                'Total Gross Amount Due for the Year',                
                'Let Address',
                'Let Address Postcode',
                'Tax Year',
                'Your Company/Organisation\'s Name'
            ]
        ];

        // Export the data as a CSV
        $this->exportToCsv([
            'file_name' => 'Statements Created',
            'data' => $results,
            'column_formatting' => $column_formatting,
            'row_manip' => $row_manip
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

                if (isset($data['column_formatting'])) {
                    $sheet->setColumnFormat($data['column_formatting']);
                }

                $sheet->fromArray($data['data']);

                if (isset($data['row_manip'])) {
                    foreach ($data['row_manip'] as $row => $values) {
                        $sheet->row($row, $values);
                    }
                }
            });
        })->export('xls');
    }
}
