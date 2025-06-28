<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\FunctionalArea;
use App\Models\Vapp\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class FunctionalAreaController extends Controller
{
    //
    public function index()
    {
        $funcareas = FunctionalArea::all();
        $venues = $funcareas;
        return view('vapp.setting.funcareas.list', compact('venues', 'funcareas'));
    }

    public function get($id)
    {
        $funcarea = FunctionalArea::findOrFail($id);
        return response()->json(['funcarea' => $funcarea]);
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $funcarea = FunctionalArea::orderBy($sort, $order);

        if ($search) {
            $funcarea = $funcarea->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $funcarea->count();
        $funcarea = $funcarea->paginate(request("limit"))->through(function ($funcarea) {

        // $location = Location::find($funcarea->location_id);

            return  [
                'id' => $funcarea->id,
                'title' => '<div class="align-middle white-space-wrap fs-9 ps-3">' . $funcarea->title . '</div>',
                'focal_point_name' => '<div class="align-middle white-space-wrap fs-9 ps-3">' . $funcarea->focal_point_name . '</div>',
                'focal_point_email' => '<div class="align-middle white-space-wrap fs-9 ps-3">' . $funcarea->focal_point_email . '</div>',
                'fa_code' => '<div class="align-middle white-space-wrap fs-9 ps-3">' . $funcarea->fa_code . '</div>',
                'created_at' => format_date($funcarea->created_at,  'H:i:s'),
                'updated_at' => format_date($funcarea->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $funcarea->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $funcarea = new FunctionalArea();

        $rules = [
            'title' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Functional Area created succesfully.' . $funcarea->id;

            $funcarea->title = $request->title;
            $funcarea->fa_code = $request->fa_code;
            $funcarea->focal_point_name = $request->focal_point_name;
            $funcarea->focal_point_email = $request->focal_point_email;
            $funcarea->active_flag = 1;

            $funcarea->save();


        }

        $notification = array(
            'message'       => 'Functional Area created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);

    }

    public function update(Request $request)
    {
        $op = FunctionalArea::findOrFail($request->id);
        $user_id = Auth::user()->id;

        $rules = [
            'title' => 'required',
            'fa_code' => 'required',
            'focal_point_name' => 'required',
            'focal_point_email' => 'required',
            // 'active_flag' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Log::info($validator->errors());
            $error = true;
            // $message = 'Employee not create.' . $op->id;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {
            $error = false;
            $message = 'Functional Area ' . $op->name . ' successfully updated';
            $op->title = $request->title;
            $op->fa_code = $request->fa_code;
            $op->focal_point_name = $request->focal_point_name;
            $op->focal_point_email = $request->focal_point_email;
            // $op->active_flag = $request->active_flag;
            $op->updated_by = $user_id;

            $op->save();
        }

        return response()->json([
            'error' => $error,
            'message' => $message,
        ]);
    }

    public function delete($id)
    {
        $ws = FunctionalArea::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'Functional Area deleted succesfully.';

        $notification = array(
            'message'       => 'Functional Area deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

}
