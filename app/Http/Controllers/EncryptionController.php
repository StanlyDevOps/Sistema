<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class EncryptionController extends Controller
{
    //

    public function encriptar(Request $request)
   {
      $cadena = $request->route('cadena', false);
      if (!$cadena) {
        echo('Debes proporcionar una cadena!');
      }
      
     
      $cacena = urldecode($cadena);
      $cadenaEncriptada = Crypt::encryptString($cadena);
      print_r($cadenaEncriptada);
   }

   public function desencriptar(Request $request)
   {
      $cadena = $request->route('cadena', false);
      if (!$cadena){
        echo('Debes proporcionar una cadena!');
      }
    
      
      $cacena = urldecode($cadena);
      $cadenaDesencriptada = Crypt::decryptString($cadena);
      print_r($cadenaDesencriptada);
   }
}
