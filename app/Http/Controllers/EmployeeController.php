<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
      public function index()
    {
        $query = Employee::with('district', 'creator');

        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('created_by', Auth::id());
        }

        $datas = $query->latest()->paginate(config('pagination.per_page'));;

        return view('backend.employee.index', compact('datas'));
    }


}
