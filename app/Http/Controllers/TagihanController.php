<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Models\TagihanDetail;
use App\Models\Pembayaran; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Biaya;

class TagihanController extends Controller
{
    private $viewIndex = 'tagihan_index';
    private $viewCreate = 'tagihan_form';
    private $viewEdit = 'tagihan_form';
    private $viewShow = 'tagihan_show';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->filled('bulan') && $request->filled('tahun') ) {
            $models = Model::latest()
            ->whereMonth('tanggal_tagihan', $request->bulan)
            ->whereYear('tanggal_tagihan', $request->tahun)
            ->paginate(50);
        }else{
            $models = Model::Latest()->paginate(50);
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Tagihan'
            
        
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $siswa = Siswa::all();
        $data = [
            'model'     => new Model(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . 'store',
            'button'    => 'SIMPAN',
            'title' => 'Form Data Tagihan',
            'angkatan' => $siswa->pluck('angkatan', 'angkatan'),
            'kelas' => $siswa->pluck('kelas', 'kelas'),
            'biaya' => Biaya::get(),
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagihanRequest $request)
{
    $validatedData = $request->validated();
    $biayaIdArray = $validatedData['biaya_id'];

    $siswaQuery = Siswa::query();

    if (!empty($validatedData['kelas'])) {
        $siswaQuery->where('kelas', $validatedData['kelas']);
    }
    if (!empty($validatedData['angkatan'])) {
        $siswaQuery->where('angkatan', $validatedData['angkatan']);
    }

    $siswa = $siswaQuery->get();

    foreach ($siswa as $item) {
        $tagihan = Model::firstOrCreate(
            [
                'siswa_id' => $item->id,
                'tanggal_tagihan' => $validatedData['tanggal_tagihan'],
                // Sesuaikan kondisi sesuai kebutuhan, contoh: 'angkatan' => $validatedData['angkatan']
            ],
            [
                'angkatan' => $validatedData['angkatan'],
                'kelas' => $validatedData['kelas'],
                'tanggal_jatuh_tempo' => $validatedData['tanggal_jatuh_tempo'],
                'keterangan' => $validatedData['keterangan'],
                'status' => 'baru'
            ]
        );

        foreach ($biayaIdArray as $biayaId) {
            $biaya = Biaya::find($biayaId);

            TagihanDetail::create([
                'tagihan_id' => $tagihan->id,
                'nama_biaya' => $biaya->nama,
                'jumlah_biaya' => $biaya->jumlah,
            ]);
        }
    }

    flash("Data tagihan berhasil disimpan")->success();
    return redirect()->route($this->routePrefix . '.index');
}



    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {
        $tagihan = Model::with('pembayaran')->findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['priode'] = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('F Y');
        $data ['model'] = new Pembayaran();
        return view('operator.' . $this->viewShow, $data);
        

    }

    
    public function destroy(Request $tagihan,$id)
    {
        $tagihan = Model::findorFail($id);
        $tagihan->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
