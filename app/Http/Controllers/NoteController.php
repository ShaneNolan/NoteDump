<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Config;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('index')->with(array(
        'title' => 'Note Dump'
      ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'message' => 'required'
      ]);

      $key = bin2hex(openssl_random_pseudo_bytes(16));
      $crypter = new \Illuminate\Encryption\Encrypter($key, Config::get('app.cipher'));
      $note = new Note;
      $note->message = $crypter->encrypt($request->input('message'));
      $note->save();

      return redirect('/')->with('r_message', url()->current() . "/" . $note->id . "/" . $key);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function get($id, $key)
    {
      $note = Note::where('id', $id)->first();
      if($note->count()){
        if(strlen($key) == 32){
          try{
            $crypter = new \Illuminate\Encryption\Encrypter($key, Config::get('app.cipher'));
            $decrypted = $crypter->decrypt($note->message);
            if(!$note->delkey)
              $note->delkey = bin2hex(openssl_random_pseudo_bytes(4));
            $note->save();

            return redirect('/')->with(array('n_message' => $decrypted, 'n_id' => $note->id, 'n_key' => $note->delkey));
          }catch(\Illuminate\Contracts\Encryption\DecryptException $ex){ }
        }
      }
      return redirect('/')->with('r_message', "Invalid note.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $this->validate($request, [
        'id' => 'required',
        'key' => 'required'
      ]);

      $note = Note::where('id', $request->input('id'))->first();
      if($note->count()){
        if($request->input('key') == $note->delkey){
          $note->delete();
          return redirect('/')->with('r_message', "Destroyed note successfully!");
        }
      }
      return redirect('/')->with('r_message', "Unable to destory note.");
    }
}
