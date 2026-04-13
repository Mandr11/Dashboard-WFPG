<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatasetController extends Controller
{
    public function index()
    {
        $datasets = Dataset::latest()->get();
        return view('dashboard.index', compact('datasets'));
    }

    public function store(Request $request)
    {
        $request->validate(['files.*' => 'required|mimes:csv,txt']);

        if($request->hasfile('files')) {
            foreach($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                
                // Simpan file ke disk 'local'
                $path = $file->storeAs('datasets', $name, 'local'); 
                
                $rawPath = Storage::disk('local')->path($path);
                
                $safePath = str_replace('\\', '/', $rawPath);

                Dataset::create([
                    'nama_file' => $name,
                    'path_file' => $safePath
                ]);
            }
        }
        return back()->with('success', 'File berhasil diunggah!');
    }
    public function destroy($id)
    {
        $dataset = Dataset::findOrFail($id);
        if(file_exists($dataset->path_file)){
            unlink($dataset->path_file);
        }
        $dataset->delete();
        return back()->with('success', 'File berhasil dihapus.');
    }

    public function analyze(Request $request)
    {
        $datasets = Dataset::all();
        if($datasets->isEmpty()){
            return back()->with('error', 'Belum ada dataset yang diunggah.');
        }

        // Gabungkan semua path file dengan koma
        $paths = $datasets->pluck('path_file')->implode(',');
        $minWs = $request->input('min_ws', 0.003);
        $minConf = $request->input('min_conf', 0.5);

        // Panggil Python (Pastikan 'python' atau 'python3' sesuai OS Anda)
        $scriptPath = storage_path('app/python/wfp_engine.py');
        $pythonExe = base_path('venv-python/Scripts/python.exe'); 
        $env = [
            'SystemRoot' => getenv('SystemRoot') ?: 'C:\Windows',
            'PATH' => getenv('PATH')
        ];

        $process = new Process([$pythonExe, $scriptPath, $paths, $minWs, $minConf], null, $env);
        $process->setTimeout(300); 
        $process->run();

        if (!$process->isSuccessful()) {
            return back()->with('error', 'Error Eksekusi Python: ' . $process->getErrorOutput());
        }

        $result = json_decode($process->getOutput(), true);

        if ($result['status'] === 'error') {
            return back()->with('error', 'Algoritma Error: ' . $result['message']);
        }

        \Illuminate\Support\Facades\Cache::put('latest_wfp_result', $result, now()->addDays(7));

        // Alihkan ke rute halaman hasil
        return redirect()->route('dataset.hasil')->with('success', 'Data berhasil dianalisis!');
    }
    public function hasil()
    {
        // Ambil data yang sudah disimpan di Cache tadi
        $result = \Illuminate\Support\Facades\Cache::get('latest_wfp_result');
        
        // Jika belum ada data di Cache, tendang balik ke halaman Manajemen Dataset
        if (!$result) {
            return redirect()->route('dataset.index')->with('error', 'Belum ada hasil analisis yang tersimpan. Silakan proses data terlebih dahulu.');
        }

        // Tampilkan halaman grafik tanpa perlu loading Python
        return view('dashboard.result', compact('result'));
    }

    public function menuBundling()
    {
        // Ambil data analisis terakhir dari Cache
        $result = \Illuminate\Support\Facades\Cache::get('latest_wfp_result');
        
        // Jika belum ada data, kembalikan ke halaman awal
        if (!$result || !isset($result['bundling'])) {
            return redirect()->route('dataset.index')->with('error', 'Belum ada data bundling. Silakan proses analisis data terlebih dahulu.');
        }

        // Tampilkan halaman cetak menu dengan membawa data hasil algoritma
        return view('dashboard.menu_bundling', compact('result'));
    }
}