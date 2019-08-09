<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Socmed;
use App\Account;

class AccountSocmedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socmed = Socmed::with(['account'])->orderBy('name', 'asc')->get();

        return $socmed;
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
            'password' => 'required'
        ]);

        $account = Account::create([
            'user_id' => 1,
            'socmed_id' => $request->socmed_id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'description' => $request->description
        ]);

        return $account;
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
        $account = Account::findOrFail($id);

        $account->update([
            'socmed_id' => $request->socmed_id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'description' => $request->description,
        ]);

        return $account;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account  = Account::findOrFail($id);

        $account->delete();

        return [
            'msg' => 'deleted'
        ];
    }
}
