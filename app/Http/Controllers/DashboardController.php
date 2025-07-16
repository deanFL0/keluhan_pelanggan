<?php

namespace App\Http\Controllers;

use App\Models\KeluhanPelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];

        $keluhan = KeluhanPelanggan::oldest()->take(10)->get();

        $keluhan->transform(function ($item) {
            $item->age = Carbon::parse($item->created_at)->diffInDays();
            return $item;
        });
        
        $data['recent_keluhan'] = $keluhan;

        // Pie chart data
        $data['pie_chart'] = [
            'total_keluhan' => KeluhanPelanggan::count(),
            'received' => KeluhanPelanggan::where('status_keluhan', '0')->count(),
            'in_process' => KeluhanPelanggan::where('status_keluhan', '1')->count(),
            'done' => KeluhanPelanggan::where('status_keluhan', '2')->count(),
        ];

        // Bar chart data
        $barDataRaw = KeluhanPelanggan::select(
            DB::raw("MONTH(created_at) as month"),
            'status_keluhan',
            DB::raw("COUNT(*) as total")
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month', 'status_keluhan')
            ->orderBy('month')
            ->get();

        // Transform bar chart data
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $datasets = ['0' => array_fill(0, 12, 0), '1' => array_fill(0, 12, 0), '2' => array_fill(0, 12, 0)];

        foreach ($barDataRaw as $item) {
            $monthIndex = $item->month - 1;
            $status = $item->status_keluhan;
            $datasets[$status][$monthIndex] = $item->total;
        }

        $data['bar_chart'] = [
            'labels' => $months,
            'datasets' => $datasets,
        ];

        return response()->json([
            'message' => 'Dashboard data retrieved successfully',
            'data' => $data,
        ]);
    }
}
