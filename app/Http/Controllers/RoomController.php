<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::paginate(6); // untuk buat page
        // $rooms = Room::all(); //return record yang belum kena delete
        // $rooms = Room::withTrashed()->get(); //return record termasuk dah kena delete

        return view('admin.room_index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = new Room;
        return view('admin.room_form', compact('room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'size' => 'required|integer|min:1',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'status' => 'required|in:0,1',
        ]);

        // $room = new Room($request->all());
        $room = new Room($request->only('name', 'description', 'size', 'status'));

        // $room->name = $request['name'];
        // $room->description = $request['description'];
        // $room->size = $request['size'];
        // $room->status = $request['status'];

        // $room->save($request->all());

        if ($request['photo']) {
            $directory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos';
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $file_name = 'room_photo_' . time() . '.' . $request->photo->getClientOriginalExtension();

            $file = $request['photo'];
            $file->move($directory, $file_name);

            $room->photo = $file_name;
        }

        $room->save();

        return redirect()->route('admin.room.index');
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
    public function edit($id)
    {
        $room = Room::find($id);
        return view('admin.room_form', compact('room'));
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'size' => 'required|integer|min:1',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'status' => 'required|in:0,1',
        ]);

        $room = Room::find($id);

        $room->name = $request['name'];
        $room->description = $request['description'];
        $room->size = $request['size'];
        $room->status = $request['status'];

        if ($request['photo']) {
            $directory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos';
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $file_name = 'room_photo_' . time() . '.' . $request->photo->getClientOriginalExtension();

            $file = $request['photo'];
            $file->move($directory, $file_name);

            $room->photo = $file_name;
        }

        $room->save();

        return redirect()->route('admin.room.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        $room->delete(); //soft delete
        //$user->forceDelete(); //hard delete

        return redirect()->route('admin.room.index');
    }
}
