<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Models\TagihanDetail;
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

        
        $requestData = $request->validated();
        $biayaIdArray = $requestData['biaya_id'];
        $siswa = Siswa::latest();

        if ($requestData['kelas'] != '') {
            $siswa->where('kelas', $requestData['kelas']);
        }
        if ($requestData['angkatan'] != '') {
            $siswa->where('angkatan', $requestData['angkatan']);
        }
        $siswa = $siswa->get();
        foreach ($siswa as $item) {
            $itemSiswa = $item;
            $biaya = Biaya::wherein('id', $biayaIdArray)->get();
            $dataTagihan = [
                'siswa_id' => $itemSiswa->id,
                'angkatan' => $requestData['angkatan'],
                'kelas' => $requestData['kelas'],
                'tanggal_tagihan' => $requestData['tanggal_tagihan'],
                'tanggal_jatuh_tempo' => $requestData['tanggal_jatuh_tempo'],
                'keterangan' => $requestData['keterangan'],
                'status' => 'baru'
            ];
            $tanggalJatuhTempo = Carbon::parse($requestData['tanggal_jatuh_tempo']);
            $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
            $bulanTagihan = $tanggalTagihan->format('m');
            $tahunTagihan = $tanggalTagihan->format('Y');
            $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                        ->whereMonth('tanggal_tagihan', $bulanTagihan)
                        ->whereYear('tanggal_tagihan', $tahunTagihan)
                        ->first();
                    if ($cekTagihan == null) {
                        //simpan data
                      $tagihan = Model::create($dataTagihan);
                      foreach ($biaya as $itemBiaya) {
                        TagihanDetail::create([
                            'tagihan_id' => $tagihan->id,
                            'nama_biaya' => $itemBiaya->nama,
                            'jumlah_biaya' => $itemBiaya->jumlah,
                            
                        ]);
                      }
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
        $tagihan = Model::with('siswa','tagihanDetails','user')->findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['priode'] = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('F Y');
        return view('operator.' . $this->viewShow, $data);
        

    }

    
    public function destroy(Model $tagihan)
    {
        //
    }
}
