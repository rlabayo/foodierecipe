<?php

namespace App\Http\Controllers;

use App\Libraries\CommonLibrary;
use App\Logging\CustomFile;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class AdminController extends Controller
{
    public $common_library;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->common_library = new CommonLibrary();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'admin_verified', 'created_at')
                    ->paginate(10);
        return view('web.admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verify_account(Request $request){
        try{
            if($request->id != ''){
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

                $user = User::find($decrypted_id);
    
                $user->update([
                    'admin_verified' => 1
                ]);
            }
            return redirect(route('admin.index'));
        }catch(Throwable $e){
            CustomFile::index("AdminController", "error", [
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()]
            ]);

            return back();
        }
    }
}
