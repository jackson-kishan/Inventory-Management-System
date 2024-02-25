<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    public function CustomerPage() {
       return view('pages.dashboard.customer-page');      
    }

    public function CustomerCreate(Request $request) {
        $user_id = $request->header('id');

        return Customer::create([
           'name' => $request->input('name'),
           'email' => $request->input('email'),
           'mobile' => $request->input('mobile'),
           'user_id' => $user_id
        ]);
    }

    public function CustomerList(Request $request) {
        $user_id = $request->header('id');
        return Customer::where('user_id', '=', $user_id)->get();
    }

    public function CustomerDelete(Request $request) {
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id', '=', $user_id)
                        ->where('id', '=', $customer_id)
                        ->delete();
    }

    public function CustomerByID(Request $request) {
        sleep(5);
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return Customer::where('user_id', $user_id)
                        ->where('id', '=', $customer_id)
                        ->first();
    }

    public function CustomerUpdate(Request $request) {
       $customer_id = $request->input('id');
       $user_id = $request->header('id');
       return Customer::where('user_id', $user_id)
                       ->where('id', '=', $customer_id)
                       ->update([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'mobile' => $request->input('mobile'),
                       ]);
    }
}
