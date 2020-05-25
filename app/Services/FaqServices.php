<?php

namespace App\Services;

use App\FaqDAO;
use Illuminate\Http\Request;
use App\Services\ResponsePresentationLayer;

class FaqServices {
  function __construct()
  {
    $this->modelFaq = new FaqDAO();
  }

  public function aksiMenampilkanSemuaFaq(){
    try {
      $data = $this->modelFaq->get();
      if(count($data) == 0){
        $response = new ResponsePresentationLayer(404, "Data tidak ditemukan", [], true);
        return $response->getResponse();
      }
      $response = new ResponsePresentationLayer(200, "Data Berhasil ditemukan", $data, false);

    } catch (\Exception $e) {
        $errors[] = $e->getMessage();
        $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }

  public function aksiAmbilFaqBerdasarkanId($id){
    try {
        $data = $this->modelFaq->find($id);
        if($data){
            $response = new ResponsePresentationLayer(200, "Data Berhasil ditemukan", $data, false);
        }else{
            $response = new ResponsePresentationLayer(404, "Data tidak ditemukan", [], true);
        }

    } catch (\Exception $e) {
        $errors[] = $e->getMessage();
        $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }

  public function aksiTambahFaq($request){
    try {
        // tambah data faq ke database
        $storeData = $this->modelFaq->create([
          "pertanyaan" => $request->input("pertanyaan"),
        ]);
        $storeData["displayed"] = false;
        $response = new ResponsePresentationLayer(201, "Sukses Menambah FAQ", $storeData, false);
    } catch (\Exception $e) {
        $errors[] = $e->getMessage();
        $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }

}