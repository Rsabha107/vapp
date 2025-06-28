<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\DeliveryRsp;
use App\Models\Vapp\Venue;
use App\Models\Vapp\ParkingCapacity;
use App\Models\Vapp\VehicleType;
use App\Models\Vapp\Event;
use App\Models\Vapp\ParkingMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class ParkingCapacityController extends Controller
{
    //
    public function index()
    {
        $parking_master = ParkingMaster::all();
        $events = Event::all();
        $venues = Venue::all();
        $vehicle_types = VehicleType::all();

        return view('vapp.setting.parking.list', compact('parking_master', 'venues', 'vehicle_types', 'events'));
    }

    public function get($id)
    {
        $schedules = ParkingCapacity::findOrFail($id);
        return response()->json(['schedules' => $schedules]);
    }

    public function list()
    {
        Log::info('inside Admin ParkingCapacityController::list');
        Log::info(request()->all());

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";
        $mds_date_range_filter = (request()->mds_date_range_filter) ? request()->mds_date_range_filter : "";


        $ops = ParkingCapacity::orderBy($sort, $order);

        if ($search) {
            $ops = $ops->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        if ($mds_schedule_event_filter) {
            $ops = $ops->where('event_id', $mds_schedule_event_filter);
        }

        if ($mds_schedule_venue_filter) {
            $ops = $ops->where('venue_id', $mds_schedule_venue_filter);
        }

        if ($mds_schedule_rsp_filter) {
            $ops = $ops->where('rsp_id', $mds_schedule_rsp_filter);
        }


        if ($mds_date_range_filter) {
            $dates = explode('to', $mds_date_range_filter);
            // Log::info('mds_date_range_filter: ' . $mds_date_range_filter);
            // Log::info('dates: ' . count($dates));
            $startDate = trim($dates[0]);
            // Log::info($dates.length);
            if( count($dates) > 1) {
                $endDate = trim($dates[1]);
            } else {
                $endDate = null;
            }
            // Log::info('startDate: ' . $startDate);
            // Log::info('endDate: ' . $endDate);
            if ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/y', $startDate)->toDateString();
            }
            if ($endDate) {
                $endDate = Carbon::createFromFormat('d/m/y', $endDate)->toDateString();
            }

            if ($startDate && $endDate) {
                $ops = $ops->whereBetween('booking_date', [$startDate, $endDate]);
            } else if ($startDate) {
                $ops = $ops->where('booking_date', '>=', $startDate);
            } else if ($endDate) {
                $ops = $ops->where('booking_date', '<=', $endDate);
            }
            // $ops = $ops->whereBetween('booking_date', [$startDate, $endDate]);
        }

        // Carbon::createFromFormat('d/m/Y', $request->slot_visibility)->toDateString()


        $total = $ops->count();
        $ops = $ops->paginate(request("limit"))->through(function ($op) {
            // $ops = $ops->paginate(request("limit"))->through(function ($op) {

                $div_action = '<div class="font-sans-serif btn-reveal-trigger position-static">';

                $update_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" id="edit_parking_capacity_offcanv" data-id=' . $op->id .
                    ' data-table="parking_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                    '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                $duplicate_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" id="duplicate_employee" data-action="update" data-type="duplicate" data-id=' .
                    $op->id .
                    ' data-table="parking_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Duplicate">' .
                    '<i class="fa-solid fa-copy text-success"></i></a>';
                $delete_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" data-table="parking_table" data-id="' .
                    $op->id .
                    '" id="delete_parking_capacity" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                    '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            $actions = $div_action . $update_action . $delete_action;

            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->event?->name . '</div>',
                'parking_code' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->parking_master?->parking_code . '</div>',
                'venue' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->venue?->title . '</div>',
                'vehicle_type' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->vehicle_type?->title . '</div>',
                'vapp_size' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->vehicle_type->vappSize->title . '</div>',
                'capacity' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->capacity . '</div>',
                'actions' => $actions,
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
        $op = new ParkingCapacity();

        $rules = [
            'parking_id' => 'required',
            'event_id' => 'required',
            'venue_id' => 'required',
            'vehicle_type_id' => 'required',
            'capacity' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Parking created succesfully.' . $op->id;

            $op->venue_id = $request->venue_id;
            $op->event_id = $request->event_id;
            $op->vehicle_type_id = $request->vehicle_type_id;
            // $op->parking_code = $request->parking_code;
            $op->parking_id = $request->parking_id;
            $op->capacity = intval($request->capacity);
            $op->active_flag = 1;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();
        }

        $notification = array(
            'message'       => 'Parking created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function update(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = ParkingCapacity::find($request->id);

        $rules = [
            'parking_id' => 'required',
            'event_id' => 'required',
            'venue_id' => 'required',
            'vehicle_type_id' => 'required',
            'capacity' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Parking updated succesfully.' . $op->id;

            $op->venue_id = $request->venue_id;
            $op->event_id = $request->event_id;
            $op->vehicle_type_id = $request->vehicle_type_id;
            $op->parking_id = $request->parking_id;
            $op->capacity = intval($request->capacity);
            $op->updated_by = $user_id;

            $op->save();
        }

        $notification = array(
            'message'       => 'Parking updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        $ws = ParkingCapacity::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'Parking deleted succesfully.';

        $notification = array(
            'message'       => 'Parking deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

    public function getParkingView($id)
    {
        $parking = ParkingCapacity::find($id);
        $events = Event::all();
        $venues = Venue::all();
        $vehicleTypes = VehicleType::all();

        $view = view('/vapp/setting/parking/mv/edit', [
            'parking' => $parking,
            'venues' => $venues,
            'vehicleTypes' => $vehicleTypes,
            'events' => $events,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function getProjectView

}
