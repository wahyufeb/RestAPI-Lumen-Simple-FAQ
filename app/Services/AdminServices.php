<?php

namespace App\Services;

use App\FaqDAO;
use App\AdminDAO;
use App\Services\ResponsePresentationLayer;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class AdminServices{

  function __construct()
  {
    // instance model
    $this->modelAdmin = new AdminDAO();
    $this->modelFaq = new FaqDAO();
  }

  public function generateToken($id){
    $key = env('APP_KEY');
    $payload = [
      'iss' => 'lumen-jwt',
      'sub' => $id,
      'iat' => time(),
      'exp' => time() + 60 * 60
    ];

    return JWT::encode($payload, $key);
  }

  // MENGGUNAKAN MODEL ADMIN

  // autentiaksi admin
  public function aksiAutentikasiAdmin($request){
    $username = $request->input('username');
    $password = $request->input('password');

    try {
      $adminData = $this->modelAdmin->where('username', $username)->first();
      // cek jika username tidak ada
      if(!$adminData){
        $response = new ResponsePresentationLayer(400, "Username tidak ditemukan", [], true);
        return $response->getResponse();
      }
      if(Hash::check($password, $adminData->password)){
        // generate JWT token dan update kolom token di database
        $token = $this->generateToken($adminData->id);
        $adminData->token = $token;
        $adminData->save();

        $response = new ResponsePresentationLayer(201, "Username dan password benar", $adminData, false);
      }else{
        $response = new ResponsePresentationLayer(500, "Password Anda salah", [], true);
      }
    } catch (\Exception $e) {
      $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $e);
    }
    return $response->getResponse();
  }

  // pendaftaran admin
  public function aksiRegistrasiAdmin($request){
    try {
      // tambah admin
      $adminData = $this->modelAdmin->create([
        "username" => $request->input("username"),
        "email" => $request->input("email"),
        "name" => $request->input("name"),
        "password" => Hash::make($request->input("password"))
      ]);

      if($adminData){
        $response = new ResponsePresentationLayer(201, "Berhasil menambahkan admin", $adminData, false);
      }else{
        $response = new ResponsePresentationLayer(500, "Gagal menambahkan admin", [], true);
      }
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();
      $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }


  // MENGGUNAKAN MODEL FAQ
  
  // tambah FAQ dari sisi admin
  public function aksiTambahFaq($request){
    try {
        // tambah data faq ke database
        $storeData = $this->modelFaq->create([
          "pertanyaan" => $request->input("pertanyaan"),
          "jawaban" => $request->input("jawaban")
        ]);
        $response = new ResponsePresentationLayer(201, "Sukses Menambah FAQ", $storeData, false);
    } catch (\Exception $e) {
        $errors[] = $e->getMessage();
        $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }

  //  update FAQ dari sisi admin
  public function aksiUpdateFaq($request, $id){
    try {
        $findOne = $this->modelFaq->find($id);
        if(!$findOne){
          $response = new ResponsePresentationLayer(404, "Data tidak ditemukan", [], true);
          return $response->getResponse();
        }
        // update data faq ke database
        $findOne->update($request->all());
        $response = new ResponsePresentationLayer(201, "Sukses Mengupdate FAQ", $findOne, false);
    } catch (\Exception $e) {
        $errors[] = $e->getMessage();
        $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }

  //  hapus FAQ dari sisi admin
  public function aksiHapusFaq($id){
    try {
        $findOne = $this->modelFaq->find($id);
        if(!$findOne){
          $response = new ResponsePresentationLayer(404, "Data tidak ditemukan", [], true);
          return $response->getResponse();
        }
        // delete data faq di database
        $findOne->delete();
        $response = new ResponsePresentationLayer(201, "Sukses menghapus FAQ", $findOne, false);
    } catch (\Exception $e) {
        $errors[] = $e->getMessage();
        $response = new ResponsePresentationLayer(500, "Terjadi kesalahan pada server", [], $errors);
    }
    return $response->getResponse();
  }
  





}
