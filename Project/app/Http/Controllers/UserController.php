<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException; //find or fail error exception class (findOrFail())
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use Hash;

class UserController extends Controller {
  public function showProfile($id) {
      $this->authorize('show', Auth::user());
      $user = User::findOrFail($id);
      
      if (!Auth()->user()->isAdmin()){
        $this->authorize('show', $user);
      }

      return view('pages.profile', ['user' => $user]);
  }

  public function showAllUsers() {
    $this->authorize('admin', Auth::user());

    $allUsers = User::orderBy('id')->where('id', '!=',  Auth::user()->id)->paginate(20);

    return view('pages.adminManageUsers', ['allUsers' => $allUsers]);
  }

  public function destroy(Request $request) {
    $this->authorize('admin', Auth::user());

    User::where('id', $request->id)->delete();
    return response(200);
  }

  public function updateProfileData($id, Request $request) {
    $user = User::findOrFail($id);

    $this->authorize('editProfile', $user);

    if ($request->phonenumber == "") {
      User::where('id', $id)->update(['name'=> $request->username, 'email' => $request->email]);
    }
    else {
      User::where('id', $id)->update(['name'=> $request->username, 'email' => $request->email, 'phonenumber' => $request->phonenumber]);
    }

    return redirect('profile/' . $id);
  }

  public function searchUsers(Request $search_request) {
    $this->authorize('admin', Auth::user());

    $searchUsers = User::where('name','LIKE','%' . $search_request->search . '%')->orderBy('name')->paginate(20);

    return view('pages.search', ['searchUsers' => $searchUsers, 'searchStr' => $search_request->search] );
  }

  public function updateUserPassword($id, Request $request) {
    $user = User::findOrFail($id); // get the user
    $this->authorize('editProfile', $user);

    $oldpassword = $request->oldPassword;
    $newpassword = $request->newPassword;
    $confirmpassword = $request->confirmPassword;

    if (Hash::check($oldpassword, $user->password)) { // Old password matches the new password
      if ($newpassword != "" && $confirmpassword != "" && $newpassword == $confirmpassword) { // If newPassord matches the confirmPassword
        User::where('id', $id)->update(['password' => bcrypt($newpassword)]);
      }
      else {
        error_log("newPassword and confirmPassword don't match!");
      }
    }
    else {
      error_log("oldPassword does not match the user password!");
    }

    return redirect('profile/' . $id);
  }

  public function deleteAddress(Request $request) {
    $this->authorize('edit', Auth::user());
    if (Auth::check()) {
      $user = Auth::user();
      $address = $user->address()->where('idaddress', $request->addressID)->first();
    }
    if($address != null){
      $user->address()->detach([$address->id]);
      return response(200);
    }
    return response(401);
  }

  public function addAddress(Request $request) {   

    if (Auth::check()) {
      $user = Auth::user();

      $address = new Address;

      $address->street = $request->new_address_city;
      $address->postalcode = $request->new_address_postacode;
      $address->city = $request->new_address_city;
      $address->country = $request->new_address_country;

      $address->save();

      Auth::user()->address()->attach($address);

      return response(200);
    } else {
      return response(401);
    }
  }

  public function deleteAccount() {
    $this->authorize('edit', Auth::user());
    
    if (Auth::check()) {
      $user = Auth::user();
      $user->delete();
      return response(200);
    }
    return response(401);
  }
}