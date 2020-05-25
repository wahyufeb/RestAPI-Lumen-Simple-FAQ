<?php

namespace App\Http\Controllers;

use App\AdminDAO;
use App\Services\AdminServices;
use App\Services\FaqServices;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
      $this->middleware("jwt", ["except" => ["registration", "login",]]);
      // instance services
      $this->adminServices = new AdminServices();
      $this->faqServices = new FaqServices();
    }

    // login admin
    public function login(Request $request){
      $this->_adminValidate($request, "admin");
      return $this->adminServices->aksiAutentikasiAdmin($request);
    }

    // registrasi admin
    public function registration(Request $request){
      $this->_adminValidate($request, "registration");
      return $this->adminServices->aksiRegistrasiAdmin($request);
    }

    // validasi untuk manajemen admin
    public function _adminValidate($request, $role){
      if($role == "admin"){
        $this->validate($request, [
          'username' => 'required',
          'password' => 'required'
        ]);
      }
      if($role == "registration"){
        $this->validate($request, [
          'username' => 'required',
          'email' => 'required',
          'name' => 'required',
          'password' => 'required'
        ]);
      }
        
    }

    // validasi manajemen FAQ untuk admin
    private function _faqValidate($request){
      $this->validate($request, [
          "pertanyaan" => "required",
          "jawaban" => "required"
      ]);
    }

    // Menyimpan data FAQ dari sisi admin
    public function save(Request $request){
        $id = $request->get("id");
        if($id !== null){
            // UPDATE FAQ
            // validasi kolom FAQ
            $this->_faqValidate($request);
            return $this->adminServices->aksiUpdateFaq($request, $id);
        }else{
            // Tambah FAQ
            // validasi kolom FAQ
            $this->_faqValidate($request);
            return $this->adminServices->aksiTambahFaq($request);
        }
    }

    // Hapus FAQ
    public function delete($id){
        return $this->adminServices->aksiHapusFaq($id);
    }

    // Menjawab pertanyaan dari user
    public function answeringQuestion(Request $request, $id){
        $this->validate($request, [
            "jawaban" => "required"
        ]);
        return $this->adminServices->aksiUpdateFaq($request, $id);
    }

    // Get Admin
    public function adminData(Request $request){
      $tokenJwt = $request->auth->token;
      return $this->adminServices->aksiAmbilDataAdmin($tokenJwt);
    }
}
