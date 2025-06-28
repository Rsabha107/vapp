<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\DeliveryRsp;
use App\Models\Vapp\Venue;
use App\Models\Vapp\ParkingMaster;
use App\Models\Vapp\VehicleType;
use App\Models\Vapp\Event;
use App\Models\Vapp\FunctionalArea;
use App\Models\Vapp\VappSize;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class ParkingMasterController extends Controller
{
    //
    public function index()
    {
        $parkings = ParkingMaster::all();
        $events = Event::all();
        $venues = Venue::all();
        // $functional_areas = FunctionalArea::all();
        $vapp_sizes = VappSize::all();

        return view('vapp.setting.parking_master.list', [
            'parkings' => $parkings,
            'events' => $events,
            'venues' => $venues,
            // 'functional_areas' => $functional_areas,
            'vapp_sizes' => $vapp_sizes,
        ]);
    }

    public function get($id)
    {
        $schedules = ParkingMaster::findOrFail($id);
        return response()->json(['schedules' => $schedules]);
    }

    public function list()
    {
        // Log::info('inside Admin ParkingMasterController::list');
        // Log::info(request()->all());

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";
        $mds_date_range_filter = (request()->mds_date_range_filter) ? request()->mds_date_range_filter : "";


        $ops = ParkingMaster::orderBy($sort, $order);

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
            if (count($dates) > 1) {
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
                '<a href="javascript:void(0)" class="btn btn-sm" id="edit_parking_master_offcanv" data-id=' . $op->id .
                ' data-table="parking_master_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
            $duplicate_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="duplicate_employee" data-action="update" data-type="duplicate" data-id=' .
                $op->id .
                ' data-table="parking_master_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Duplicate">' .
                '<i class="fa-solid fa-copy text-success"></i></a>';
            $delete_action =
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="parking_master_table" data-id="' .
                $op->id .
                '" id="delete_parking_master" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            // $fa_display = '';
            // // Log::info($op);
            // // Log::info($op->functional_areas);
            // foreach ($op->functional_areas as $functional_area) {
            //     $fa_display .= '<span class="badge badge-pill bg-body-tertiary text-black">' . $functional_area->title . '</span> ';
            // }
            $vapp_size_display = '';
            foreach ($op->vapp_sizes as $vapp_size) {
                $vapp_size_display .= '<span class="badge badge-pill bg-body-tertiary text-black">' . $vapp_size->title . '</span> ';
            }
            $actions = $div_action . $update_action . $delete_action;

            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->event?->name . '</div>',
                'parking_code' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->parking_code . '</div>',
                'description' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->description . '</div>',
                'vapp_size' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $vapp_size_display . '</div>',
                // 'vapp_color' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->vapp_color . '</div>',
                'vapp_color' => '<div style="width: 40px; height: 20px; background-color: '. $op->vapp_color .'; border: 1px solid #ccc;"></div>',
                // 'fa' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $fa_display . '</div>',
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
        $op = new ParkingMaster();

        $rules = [
            'parking_code' => 'required',
            'event_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Parking Master created succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            $op->parking_code = $request->parking_code;
            $op->description = $request->description;
            $op->vapp_color = $request->vapp_color;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();

            // if ($request->fa_id) {
            //     foreach ($request->fa_id as $key => $data) {
            //         $op->functional_areas()->attach($request->fa_id[$key]);
            //     }
            // }
            if ($request->vapp_size_id) {
                foreach ($request->vapp_size_id as $key => $data) {
                    $op->vapp_sizes()->attach($request->vapp_size_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Parking Master created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function update(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = ParkingMaster::find($request->id);

        $rules = [
            'parking_code' => 'required',
            'event_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'Parking Master updated succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            $op->parking_code = $request->parking_code;
            $op->description = $request->description;
            $op->vapp_color = $request->vapp_color;
            $op->updated_by = $user_id;

            $op->save();

            $op->vapp_sizes()->detach();
            // $op->functional_areas()->detach();

            // if ($request->fa_id) {
            //     foreach ($request->fa_id as $key => $data) {
            //         $op->functional_areas()->attach($request->fa_id[$key]);
            //     }
            // }

            if ($request->vapp_size_id) {
                foreach ($request->vapp_size_id as $key => $data) {
                    $op->vapp_sizes()->attach($request->vapp_size_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Parking Master updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        $ws = ParkingMaster::findOrFail($id);
        $ws->delete();

        if ($ws->functional_areas) {
            $ws->functional_areas()->detach();
        }
        if ($ws->vapp_sizes) {
            $ws->vapp_sizes()->detach();
        }
        $error = false;
        $message = 'Parking deleted succesfully.';

        $notification = array(
            'message'       => 'Parking deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

    public function getView($id)
    {
        $parking = ParkingMaster::find($id);
        $events = Event::all();
        $venues = Venue::all();
        $functional_areas = FunctionalArea::all();
        $vapp_sizes = VappSize::all();

        $view = view('/vapp/setting/parking_master/mv/edit', [
            'parking' => $parking,
            'venues' => $venues,
            'events' => $events,
            'functionalAreas' => $functional_areas,
            'vappSizes' => $vapp_sizes,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function getProjectView

}
