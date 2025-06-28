<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\VappSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class VappSizeController extends Controller
{
    //
    public function index()
    {
        $vapp_size = VappSize::all();

        return view('vapp.setting.vapp_size.list', compact('vapp_size'));
    }

    public function get($id)
    {
        $venue = VappSize::findOrFail($id);
        return response()->json(['venue' => $venue]);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'title' => ['required'],
        ]);

        $venue = VappSize::findOrFail($request->id);

        // dd($venue);

        if ($venue->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'VAPP Size updated successfully.', 'id' => $venue->id]);
        } else {
            return response()->json(['error' => true, 'message' => 'VAPP Size couldn\'t updated.']);
        }
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $venue = VappSize::orderBy($sort, $order);

        if ($search) {
            $venue = $venue->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $venue->count();
        $venue = $venue->paginate(request("limit"))->through(function ($venue) {

        // $location = Location::find($venue->location_id);

            return  [
                'id' => $venue->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'title' => '<div class="align-middle white-space-wrap fs-9 ps-3">' . $venue->title . '</div>',
                'created_at' => format_date($venue->created_at,  'H:i:s'),
                'updated_at' => format_date($venue->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $venue->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $venue = new VappSize();

        $rules = [
            'title' => 'required|unique:vapp_sizes,title',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'VAPP Size created succesfully.' . $venue->id;

            $venue->title = $request->title;
            $venue->created_by = $user_id;
            $venue->updated_by = $user_id;
            $venue->active_flag = 1;

            $venue->save();


        }

        $notification = array(
            'message'       => 'VAPP Size created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);

    }

    public function delete($id)
    {
        $ws = VappSize::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'VAPP Size deleted succesfully.';

        $notification = array(
            'message'       => 'VAPP Size deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

}
