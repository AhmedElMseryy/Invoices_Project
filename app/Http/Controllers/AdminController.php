<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    ##----------------------------------------------------INDEX
    public function index($id)
    {
        if (view()->exists($id)) {
            return view($id);
        } else {
            return view('404');
        }

        //   return view($id);
    }

    ##----------------------------------------------------CREATE
    public function create()
    {
        //
    }

    ##----------------------------------------------------STORE
    public function store(Request $request)
    {
        //
    }

    ##----------------------------------------------------SHOW
    public function show($id)
    {
        //
    }

    ##----------------------------------------------------EDIT
    public function edit($id)
    {
        //
    }

    ##----------------------------------------------------UPDATE
    public function update(Request $request, $id)
    {
        //
    }

    ##----------------------------------------------------DELETE
    public function destroy($id)
    {
        //
    }
}
