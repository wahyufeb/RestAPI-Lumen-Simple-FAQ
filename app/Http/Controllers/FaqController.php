<?php

namespace App\Http\Controllers;

use App\FaqDAO;
use Illuminate\Http\Request;
use App\Services\FaqServices;

class FaqController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(){
        $this->faqServices = new FaqServices();
    }
    
    // validasi FAQ
    private function _faqValidate($request){
        $this->validate($request, [
            "pertanyaan" => "required",
        ]);
    }

    // Menampilkan semua FAQ
    public function showAll(){
        return $this->faqServices->aksiMenampilkanSemuaFaq();
    }

    // Menyimpan data FAQ dari sisi user
    public function save(Request $request){
        $this->_faqValidate($request);
        return $this->faqServices->aksiTambahFaq($request);
    }

    // Mencari FAQ
    public function findOne($id){
        return $this->faqServices->aksiAmbilFaqBerdasarkanId($id);
    }
}