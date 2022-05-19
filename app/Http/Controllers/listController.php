<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contact_list_model;


class listController extends Controller
{
    //

    public function index(){

    $ContactLists =  json_encode(contact_list_model::get());

    return $ContactLists;
    }
    
    public function ContactStore(Request  $Req){

   $Contact = new contact_list_model();
   $Contact->firstname = $Req->Firstname;
   $Contact->lastname = $Req->Lastname;
   $Contact->number = $Req->Number;
   $Contact->email = $Req->Email;
   $Contact->save();
   if ($Contact == true) { return 1; }else    { return 2;}

    }

    function ContactEdit(Request $req){
      $id = $req->input('id');
      $result = json_encode(contact_list_model::select('*')->where('id', '=', $id)->get());
      return ($result);
  }



      function ContactUpdate(Request $req){
        $ContactId = $req->input('ContactId');
        $Firstname = $req->input('Firstname');
        $Lastname = $req->input('Lastname');
        $Number = $req->input('Number');
        $Email = $req->input('Email');

        $result = contact_list_model::where('id', '=', $ContactId)->update(['firstname' => $Firstname,'lastname' => $Lastname,'number' => $Number,'email' => $Email, ]);
        if ($result == true) { return 1; }else    { return 2;}
    }

    function ContactDelete(Request $req){
      $id= $req->input('id');
      $result=contact_list_model::where('id','=',$id)->delete();
      if($result==true){      
        return 1;
      }
      else{
        return 0;
      }
 }

}
