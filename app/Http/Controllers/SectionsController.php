<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    ##-------------------------------------------------------INDEX
    public function index()
    {
        $sections = sections::all();
        return view('sections.sections', compact('sections'));
    }

    ##-------------------------------------------------------CREATE
    public function create()
    {
        //
    }

    ##-------------------------------------------------------STORE
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',


        ]);

        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => (auth()->user()->name),

        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');
    }

    ##-------------------------------------------------------SHOW
    public function show(sections $sections)
    {
        //
    }

    ##-------------------------------------------------------EDIT
    public function edit(sections $sections)
    {
        //
    }

    ##-------------------------------------------------------UPDATE
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
            'description' => 'required',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال البيان',

        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    ##-------------------------------------------------------DELETE
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::destroy($id);
        session()->flash('delete', 'تم حذف القسم بنجاج');
        return redirect('/sections');
    }
}
