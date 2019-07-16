<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientContact;
use App\ClientChildren;
use App\Report;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Validator;

class ClientController extends Controller
{


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => 'required|string|max:255|unique:clients',
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //         'phone_number' => 'required|string|min:6',
    //         'fax' => 'string|min:6',
    //     ]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('active', '=', 1)->get(['id', 'name', 'active','created_at']);

        return view('client.home')->with([
            'totalClients' => $clients->count(),
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $requst)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Client::where('name', '=', $request->client_name)->get(['id'])->count() != 0){
            return redirect()->route('client.index')->with([
                'status' => 'Client already exists',
                'status_class' => 'alert-warning'
            ]);
        }

        $client = new Client;
        $client->name       = $request->client_name;
        $client->active     = ($request->active == true ? 1 : 0);
        $client->creator_id = Auth::id();
        $client->notes      = json_encode([]);
        $client->save();
        // if($client->save()){

        //     $clientContact = new ClientContact;
        //     $clientContact->client_id     = $client;
        //     $clientContact->first_name    = '';
        //     $clientContact->last_name     = '';
        //     $clientContact->primary_email = '';
        //     $clientContact->phone_number  = '';
        //     $clientContact->fax           = '';
        //     $clientContact->save();

        //     if(intval($request->parent_client) !== 0){
        //         $clientChildren = new ClientChildren;
        //         $clientChildren->client_id = $client->id;
        //         $clientChildren->parent_id = $request->parent_client;
        //         $clientChildren->save();
        //     }
        // }

        return redirect()->route('client.edit', $client);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('clients')
            ->leftJoin('reports', 'clients.id', '=', 'reports.client_id')
            ->leftJoin('assessments', 'assessments.client_id', '=', 'clients.id')
            ->select('reports.id', 'reports.*', 'clients.name', 'assessments.name AS job_name')
            ->where('clients.id', '=', $id)
            ->get();

        return view('client.listclientreports', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $client = Client::find($id)->contacts()->get(['id']);
        // dd($client);

        $currentClient = Client::find($id);
        $clients = Client::where('active', '=', 1)->get(['id', 'name', 'active','created_at']);

        // $clientContact = ClientContact::find($id);
        $clientContact = ClientContact::where('client_id', '=', $id)->first();

        if(empty($clientContact)) {
            $clientContact = new \stdClass;
            $clientContact->client_id = $id;
            $clientContact->primary_email = '';
            $clientContact->first_name = '';
            $clientContact->last_name = '';
            $clientContact->phone_number = '';
            $clientContact->fax = '';
        }

        // $client = array_merge((array)$currentClient, (array)$clientContact);

        return view('client.editclient')->with([
            'clientList' => $clients,
            'currentClient'  => $currentClient,
            'clientContact' => $clientContact,
        ]);
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
        // $validator = Validator::make($request->all(), [
        //     'client_name' => 'required|min:3|string',
        //     'first_name' => 'min:3|string',
        //     'last_name' => 'string',
        //     'primary_email' => 'string|required|min:6|unique:client_contacts',
        //     'phone_number' => 'string|min:10',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //                 ->route('client.edit', $id)
        //                 ->with(['status' => $validator])
        //                 ->withInput();
        // }

        $client = Client::find($id);
        $client->name = $request->client_name;
        $client->save();

        $clientContact = ClientContact::where('client_id', '=', $id)->first();
        if(empty($clientContact)) {
            $clientContact = new ClientContact;
        }
        $clientContact->client_id     = $id;
        $clientContact->first_name    = $request->first_name;
        $clientContact->last_name     = $request->last_name;
        $clientContact->primary_email = $request->primary_email;
        $clientContact->phone_number  = $request->phone_number;
        $clientContact->fax           = empty($request->fax) ? '' : $request->fax;
        $clientContact->save();

        return redirect()->route('client.edit', $id)->with([
            'status' => 'Successfully updated record.'
        ]);
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
    }
}
