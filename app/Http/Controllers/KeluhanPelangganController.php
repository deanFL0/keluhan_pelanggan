<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeluhanPelangganRequest;
use App\Http\Resources\KeluhanPelangganResource;
use App\Models\KeluhanPelanggan;
use App\Models\KeluhanStatusHis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\KeluhanPelangganExport;
use Maatwebsite\Excel\Facades\Excel;

class KeluhanPelangganController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        return KeluhanPelangganResource::collection(KeluhanPelanggan::paginate($perPage));
    }

    public function show($id)
    {
        $keluhan = KeluhanPelanggan::with([
            'statusHistory' => function ($query) {
                $query->orderBy('updated_at', 'desc');
            }
        ])->findOrFail($id);
        return new KeluhanPelangganResource($keluhan);
    }

    public function store(KeluhanPelangganRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $keluhan = KeluhanPelanggan::create($request->validated());

            KeluhanStatusHis::create([
                'keluhan_id' => $keluhan->id,
                'status_keluhan' => $keluhan->status_keluhan,
            ]);

            return new KeluhanPelangganResource($keluhan);
        });
    }

    public function update(KeluhanPelangganRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $keluhan = KeluhanPelanggan::findOrFail($id);
            $originalStatus = $keluhan->status_keluhan;
            $keluhan->update($request->validated());

            if ($originalStatus !== $keluhan->status_keluhan) {
                KeluhanStatusHis::create([
                    'keluhan_id' => $keluhan->id,
                    'status_keluhan' => $keluhan->status_keluhan,
                ]);
            }

            return new KeluhanPelangganResource($keluhan);
        });
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $data = $request->validate([
    //         'status_keluhan' => 'required|string|in:0,1,2',
    //     ]);

    //     $keluhan = KeluhanPelanggan::findOrFail($id);

    //     if ($keluhan->status_keluhan === $data['status_keluhan']) {
    //         return response()->json([
    //             'message' => 'Status Keluhan Pelanggan is already set to this value',
    //             'data' => new KeluhanPelangganResource($keluhan)
    //         ], 200);
    //     }

    //     $keluhan->status_keluhan = $data['status_keluhan'];
    //     $keluhan->save();

    //     KeluhanStatusHis::create([
    //         'keluhan_id' => $keluhan->id,
    //         'status_keluhan' => $keluhan->status_keluhan,
    //     ]);

    //     return response()->json([
    //         'message' => 'Status Keluhan Pelanggan Berhasil diperbarui',
    //         'data' => new KeluhanPelangganResource($keluhan)
    //     ]);
    // }

    public function updateStatus($id)
    {
        $keluhan = KeluhanPelanggan::findOrFail($id);

        // Check if the status is already at the maximum
        if ($keluhan->status_keluhan >= 2) {
            return response()->json([
                'message' => 'Status Keluhan Pelanggan sudah selesai',
                'data' => new KeluhanPelangganResource($keluhan)
            ], 200);
        }

        // Increment the status using an array mapping since the field is varchar
        $statusKeluhan = array(
            0 => '0',
            1 => '1',
            2 => '2'
        );
        $keluhan->status_keluhan = isset($statusKeluhan[$keluhan->status_keluhan + 1]) ? $statusKeluhan[$keluhan->status_keluhan + 1] : $statusKeluhan[$keluhan->status_keluhan];
        $keluhan->save();

        KeluhanStatusHis::create([
            'keluhan_id' => $keluhan->id,
            'status_keluhan' => $keluhan->status_keluhan,
        ]);

        return response()->json([
            'message' => 'Status Keluhan Pelanggan Berhasil diperbarui',
            'data' => new KeluhanPelangganResource($keluhan)
        ]);
    }

    public function destroy($id)
    {
        $keluhan = KeluhanPelanggan::findOrFail($id);
        $keluhan->delete();
        return response()->json(['message' => 'Keluhan Pelanggan deleted successfully']);
    }

    public function revertStatus($id)
    {
        $keluhan = KeluhanPelanggan::findOrFail($id);

        // Get the status history
        $history = KeluhanStatusHis::where('keluhan_id', $id)->orderBy('updated_at', 'desc')->get();
        // Check if there are at least two statuses to revert to
        if ($history->count() < 2) {
            return response()->json(['message' => 'Tidak ada status sebelumnya untuk dikembalikan'], 400);
        }

        // Remove the latest status
        $latestStatus = $history->first();
        $latestStatus->delete();

        // Set the keluhan status to the previous status
        $previousStatus = $history->get(1);
        $keluhan->status_keluhan = $previousStatus->status_keluhan;
        $keluhan->save();

        return response()->json([
            'message' => 'Status Keluhan Pelanggan berhasil dikembalikan ke status sebelumnya',
            'data' => new KeluhanPelangganResource($keluhan)
        ]);
    }

    public function export($format)
    {
        $filename = 'keluhan_pelanggan_export_' . now()->format('Y-m-d');
        switch ($format) {
            case 'txt':
                return Excel::download(new KeluhanPelangganExport, $filename . '.txt', \Maatwebsite\Excel\Excel::TSV);
            case 'xls':
                return Excel::download(new KeluhanPelangganExport, $filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
            case 'csv':
                return Excel::download(new KeluhanPelangganExport, $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
            case 'pdf':
                return Excel::download(new KeluhanPelangganExport, $filename . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            default:
                return response()->json(['message' => 'Format not supported'], 400);
        }
    }
}
