<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;
use DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Users',
            'mods' => 'user'
        ];

        return view($this->defaultLayout, $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        return DataTables::of(User::all())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah User',
            'action' => route('users.store')
        ];

        return view($this->defaultLayout('user.form'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $request->merge(['password' => Hash::make($request->password)]);

            User::create($request->only(['name', 'username', 'email', 'password', 'address', 'position']));

            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [
            'title' => 'Edit User',
            'action' => route('users.update', $user->hashid),
            'values' => $user
        ];

        return view($this->defaultLayout('user.form'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $user->update($request->only(['name', 'username', 'email', 'address', 'position']));

            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $id = [];
            foreach ($request->hashid as $hashid) {
                array_push($id, Hashids::decode($hashid)[0]);
            }

            User::destroy($id);

            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e > getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function viewUpdatePassword(Request $request)
    {

        $data = [
            'title' => 'Edit Password',
            'action' => route('update-password.form', ['user' => Hashids::encode(Auth::user()->id)])
        ];

        return view($this->defaultLayout('user.update_password'), $data);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|required_with:new_password|same:new_password'
        ]);

        try {
            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return response()->json([
                    'message' => 'Data telah diupdate'
                ]);
            } else {
                return response()->json([
                    'message' => 'Password lama tidak sesuai'
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
    public function viewUpdateProfile(Request $request)
    {

        $data = [
            'title' => 'Edit Profile',
            'user' => Auth::user(),
            'action' => route('update-profile.form', ['user' => Hashids::encode(Auth::user()->id)])
        ];

        return view($this->defaultLayout('user.update_profile'), $data);
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'address' => 'required'
        ]);

        try {
            $user->update($request->only(['name', 'username', 'email', 'address']));
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
}
