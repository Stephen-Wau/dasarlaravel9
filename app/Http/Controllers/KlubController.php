<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KlubController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $klubs = Klub::latest()->paginate(5);

        //render view with posts
        return view('klubs.index', compact('klubs'));
    }

    public function create()
    {
        return view('klubs.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'number'    =>'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'      => 'required',
            'sex'      => 'required',
            'dob'      => 'required',
            'position'      => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/klubs', $image->hashName());

        //create post
        Klub::create([
            'number'    =>$request->number,
            'image'     => $image->hashName(),
            'name'      => $request->name,
            'sex'      => $request->sex,
            'dob'      => $request->dob,
            'position'      => $request->position,
        ]);

        //redirect to index
        return redirect()->route('klubs.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit(Klub $klub)
    {
        return view('klubs.edit', compact('klub'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $klub
     * @return void
     */
    public function update(Request $request, Klub $klub)
    {
        //validate form
        $this->validate($request, [
            'number'    =>'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'      => 'required',
            'sex'      => 'required',
            'dob'      => 'required',
            'position'      => 'required',
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/klubs', $image->hashName());

            //delete old image
            Storage::delete('public/klubs/'.$klub->image);

            //update post with new image
            $klub->update([
            'number'    =>$request->number,
            'image'     => $image->hashName(),
            'name'      => $request->name,
            'sex'       => $request->sex,
            'dob'       => $request->dob,
            'position'  => $request->position,
            ]);

        } else {

            //update post without image
            $klub->update([
                'number'    =>$request->number,
                'name'      => $request->name,
                'sex'       => $request->sex,
                'dob'       => $request->dob,
                'position'  => $request->position,
            ]);
        }

        //redirect to index
        return redirect()->route('klubs.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $klub
     * @return void
     */
    public function destroy(Klub $klub)
    {
        //delete image
        Storage::delete('public/klubs/'. $klub->image);

        //delete post
        $klub->delete();

        //redirect to index
        return redirect()->route('klubs.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
