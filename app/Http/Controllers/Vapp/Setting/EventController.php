<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\Event;
use App\Models\Vapp\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    //
    public function index()
    {
        $statuses = Event::all();
        $venues = Venue::all();
        return view('vapp.setting.event.list', [
            'statuses' => $statuses,
            'venues' => $venues,
        ]);
    }

    public function get($id)
    {
        $op = Event::findOrFail($id);
        return response()->json(['op' => $op, 'venues' => $op->venues]);
    }

    public function updatex(Request $request)
    {
        $formFields = $request->validate([
            'id' => ['required'],
            'name' => 'required',
            'active_flag' => 'required',
        ]);

        $status = Event::findOrFail($request->id);

        // dd($status);

        if ($status->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'Event updated successfully.']);
        } else {
            return response()->json(['error' => true, 'message' => 'Event couldn\'t be updated.']);
        }
    }

    public function list()
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $ops = Event::orderBy($sort, $order);

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        $total = $ops->count();
        $ops = $ops->paginate(request("limit"))->through(function ($op) {


            $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';
            $update_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="editEvents" data-id=' . $op->id .
                ' data-table="event_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
            $delete_action =
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="event_table" data-id="' .
                $op->id .
                '" id="deleteEvent" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';


            // $actions = $div_action . $profile_action;
            $venues_display = '';
            Log::info($op);
            Log::info($op->venues);
            foreach ($op->venues as $venue) {
                $venues_display .= '<span class="badge badge-pill bg-body-tertiary">' . $venue->short_name . '</span> ';
            }

            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-10 ps-2">' .$op->id. '</div>',
                'title' => '<div class="align-middle white-space-wrap fs-9 ps-3">' . $op->name . '</div>',
                'status' => '<span class="badge badge-phoenix fs--2 align-middle white-space-wrap ms-3 badge-phoenix-' . $op->active_status->color . ' " style="cursor: pointer;" id="editDriverStatus" data-id="' . $op->id . '" data-table="drivers_table"><span class="badge-label">' . $op->active_status->name . '</span><span class="ms-1 uil-edit-alt" style="height:12.8px;width:12.8px;cursor: pointer;"></span></span>',
                'venues' => $venues_display,
                'actions' => $update_action . $delete_action,
                'created_at' => format_date($op->created_at,  'H:i:s'),
                'updated_at' => format_date($op->updated_at, 'H:i:s'),
            ];
        });

        return response()->json([
            "rows" => $ops->items(),
            "total" => $total,
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = new Event();

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {

            $error = false;
            $message = 'Event created succesfully.' . $op->id;

            $op->name = $request->name;
            $op->active_flag = 1;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();

            if ($request->venue_id) {
                foreach ($request->venue_id as $key => $data) {
                    $op->venues()->attach($request->venue_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Event created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function update(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = Event::findOrFail($request->id);
        if (!$op) {
            return response()->json(['error' => true, 'message' => 'Event not found.']);
        }

        $rules = [
            'name' => 'required',
            'active_flag' => 'required',
            'id' => 'required|exists:events,id',
            'venue_id' => 'array',
            'venue_id.*' => 'exists:venues,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));
        } else {

            $error = false;
            $message = 'Event updated succesfully.';

            $op->name = $request->name;
            $op->active_flag = $request->active_flag;
            $op->updated_by = $user_id;

            $op->save();

            if ($op->venues) {
                $op->venues()->detach();
            }
            if ($request->venue_id) {
                foreach ($request->venue_id as $key => $data) {
                    $op->venues()->attach($request->venue_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Event updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        $op = Event::findOrFail($id);
        $op->delete();

        if ($op->venues) {
            $op->venues()->detach();
        }

        $error = false;
        $message = 'Event deleted succesfully.';

        $notification = array(
            'message'       => 'Event deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

}
