<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\Venue;
use App\Models\Vapp\DeliveryVehicleType;
use App\Models\Vapp\ParkingCapacity;
use App\Models\Vapp\Event;
use App\Models\Vapp\VappInventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class VappInventoryController extends Controller
{
    //
    public function index()
    {
        $vapp_inventory = VappInventory::all();
        $events = Event::all();
        $venues = Venue::all();
        $parkings = ParkingCapacity::all();

        return view('vapp.setting.inventory.list', compact('vapp_inventory', 'venues', 'events','parkings'));
    }

    public function get($id)
    {
        $vapp_inventory = VappInventory::findOrFail($id);
        return response()->json(['vapp_inventory' => $vapp_inventory]);
    }

    public function list()
    {
        Log::info('inside Admin VappInventoryController::list');
        Log::info(request()->all());

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";
        $mds_date_range_filter = (request()->mds_date_range_filter) ? request()->mds_date_range_filter : "";


        $ops = VappInventory::orderBy($sort, $order);

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
                    '<a href="javascript:void(0)" class="btn btn-sm" id="edit_vapp_inventory_offcanv" data-id=' . $op->id .
                    ' data-table="vapp_inventory_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                    '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
                $duplicate_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" id="duplicate_employee" data-action="update" data-type="duplicate" data-id=' .
                    $op->id .
                    ' data-table="vapp_inventory_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Duplicate">' .
                    '<i class="fa-solid fa-copy text-success"></i></a>';
                $delete_action =
                    '<a href="javascript:void(0)" class="btn btn-sm" data-table="vapp_inventory_table" data-id="' .
                    $op->id .
                    '" id="delete_vapp_inventory" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                    '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            $actions = $div_action . $update_action . $delete_action;

            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->event?->name . '</div>',
                'venue' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->venue?->title . '</div>',
                'parking_code_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->parking?->parking_code . '</div>',
                'a5_total' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->a5_total . '</div>',
                'a5_printed' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->a5_printed . '</div>',
                'a4_total' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->a4_total . '</div>',
                'a4_printed' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->a4_printed . '</div>',
                'x20_total' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->x20_total . '</div>',
                'x20_printed' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->x20_printed . '</div>',
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
        $op = new VappInventory();

        $rules = [
            'parking_code_id' => 'required',
            'event_id' => 'required',
            'venue_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'VAPP Inventory created succesfully.' . $op->id;

            $op->venue_id = $request->venue_id;
            $op->event_id = $request->event_id;
            $op->parking_code_id = $request->parking_code_id;
            $op->a5_total = intval($request->a5_total);
            $op->a5_printed = intval($request->a5_printed);
            $op->a4_total = intval($request->a4_total);
            $op->a4_printed = intval($request->a4_printed);
            $op->x20_total = intval($request->x20_total);
            $op->x20_printed = intval($request->x20_printed);
            $op->active_flag = 1;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();
        }

        $notification = array(
            'message'       => 'VAPP Inventory created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function update(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = VappInventory::find($request->id);

        $rules = [
            'parking_code_id' => 'required',
            'event_id' => 'required',
            'venue_id' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'VAPP Inventory updated succesfully.' . $op->id;

            $op->venue_id = $request->venue_id;
            $op->event_id = $request->event_id;
            $op->parking_code_id = $request->parking_code_id;
            $op->a5_total = intval($request->a5_total);
            $op->a5_printed = intval($request->a5_printed);
            $op->a4_total = intval($request->a4_total);
            $op->a4_printed = intval($request->a4_printed);
            $op->x20_total = intval($request->x20_total);
            $op->x20_printed = intval($request->x20_printed);
            $op->updated_by = $user_id;

            $op->save();
        }

        $notification = array(
            'message'       => 'VAPP Inventory updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        $ws = VappInventory::findOrFail($id);
        $ws->delete();

        $error = false;
        $message = 'VAPP Inventory deleted succesfully.';

        $notification = array(
            'message'       => 'VAPP Inventory deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

    public function getVappInventoryView($id)
    {
        $vapp_inventory = VappInventory::find($id);
        $parkings = ParkingCapacity::all();
        $events = Event::all();
        $venues = Venue::all();
        $vehicleTypes = DeliveryVehicleType::all();

        $view = view('/vapp/setting/inventory/mv/edit', [
            'vapp_inventory' => $vapp_inventory,
            'venues' => $venues,
            'vehicleTypes' => $vehicleTypes,
            'events' => $events,
            'parkings' => $parkings,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function getProjectView

}
