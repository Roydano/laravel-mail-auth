<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request){

        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        } 

        $newLead = new Lead();
        $newLead->fill($data);

        $newLead->save();


        Mail::to('info@boolpress.com' )->send(new SendNewMail($newLead));
        // Mail::to( 'proprietariosito@gmail.com' )->send(new AdminNewContact( $newLead) );

        return response()->json(['success' => true ]);
    }
}
