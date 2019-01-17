<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $contacts = Contact::orderBy('id', 'desc')->get();

        return ContactResource::collection($contacts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $contact = $request->all();
        Contact::create($contact);
        return "store success";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $contact = Contact::findOrFail($id);

        return new ContactResource($contact);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $contact = Contact::findOrFail($id);
        $result = $contact->update([
            'id' => $id,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);

        if ($result) {
            return response()->json([
                'id' => $id,
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
            ]);
        } else {
            return response()->json([
                'error' => 'Something wrong',
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $contact = Contact::findOrFail($id);
        $contact->delete();

    }
}
