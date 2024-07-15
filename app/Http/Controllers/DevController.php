<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Vtiful\Kernel\Excel;

class DevController extends Controller
{
    public function index()
    {
        return view('dev');
    }
    public function executeSql(Request $request)
    {

        $this->validate($request, [
            'sql' => 'required|string',
        ]);

        $sql = $request->input('sql');

        if (stripos($sql, 'select') !== 0) {
            return back()->with('error', 'Only SELECT queries are allowed.');
        }

        try {
            $results = DB::select($sql);

            $paginatedResults = $this->paginateResults($results);

            return view('results', ['results' => $paginatedResults]);
        } catch (\Exception $e) {
            // 记录日志
            Log::error("SQL Error: {$e->getMessage()}");
            return back()->withErrors(['sql' => "SQL Error: {$e->getMessage()}"]);
        }
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'sql' => 'required|string',
        ]);

        $sql = $request->input('sql');

        if (stripos($sql, 'select') !== 0) {
            return back()->with('error', 'Only SELECT queries are allowed.');
        }

        try {
            $results = DB::select($sql);
            return Excel::create('results', function($excel) use ($results) {
            })->download('xls');
        } catch (\Exception $e) {
            // 记录错误
            $this->logSqlExecution(auth()->id(), now(), $sql, $e->getMessage());
            return back()->with('error', 'SQL Error: ' . $e->getMessage());
        }
    }


    protected function paginateResults($results, $perPage = 10)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = array_slice($results, ($page - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator($items, count($results), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query(),
        ]);

        return $paginator;
    }
}
