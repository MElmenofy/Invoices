<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreSectionRequest;
use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //
        $sections = sections::all();
        return view('sections.sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreSectionRequest $request)
    {
        //
        $validated = $request->validated();
            sections::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'created_by' => (Auth::user()->name),
            ]);
            session()->flash('Add', 'تم اضافة القسم بنجاح');
            return redirect('/sections');

    }

    /**
     * Display the specified resource.
     *
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Request $request)
    {

//        $sections = sections::find($request -> id);
//        $sections = sections::select('id', 'section_name', 'description')->find($request ->id);
//        return view('sections.sections', compact('sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');

    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $sections = sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاج');
        return redirect('/sections');

    }
}
