<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\Venue;
use App\Models\Vapp\VappPrintBatch;
use App\Models\Vapp\Event;
use App\Models\Vapp\MatchList;
use App\Models\Vapp\ParkingMaster;
use App\Models\Vapp\VappSize;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;

class VappPrintBatchConroller extends Controller
{
    //
    public function index()
    {
        $events = Event::all();
        $venues = Venue::all();
        $matchs = MatchList::all()->sortBy('match_code');
        $parkings = ParkingMaster::with('functional_areas')->get();
        $vapp_sizes = VappSize::all();

        // dd($parkings);
        return view('vapp.setting.print_batch.list', [
            'events' => $events,
            'venues' => $venues,
            'vapp_sizes' => $vapp_sizes,
            'matchs' => $matchs,
            'parkings' => $parkings,
        ]);
    }

    public function get($id)
    {
        $variation = VappPrintBatch::findOrFail($id);
        $funcitonal_areas = $variation->functional_areas;
        $vapp_sizes = $variation->vapp_sizes;
        $venues = $variation->venues;
        $matchs = $variation->matchs;

        // get the parking master with functional areas
        $parkingMaster = ParkingMaster::with('functional_areas')
            ->with('vapp_sizes')->find($variation->variation_id);
        return response()->json([
            'variation' => $variation,
            'functional_areas' => $funcitonal_areas,
            'vapp_sizes' => $vapp_sizes,
            'venues' => $venues,
            'parkingMasterFa' => $parkingMaster?->vapp_sizes,
            'matchs' => $matchs,
        ]);
    }

    public function list()
    {
        Log::info('inside Admin VappPrintBatchController::list');
        Log::info(request()->all());

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";
        $mds_date_range_filter = (request()->mds_date_range_filter) ? request()->mds_date_range_filter : "";


        $ops = VappPrintBatch::orderBy($sort, $order);

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
                '<a href="javascript:void(0)" class="btn btn-sm" id="edit_print_batch_offcanv" data-id=' . $op->id .
                ' data-table="print_batch_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
            $duplicate_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="duplicate_employee" data-action="update" data-type="duplicate" data-id=' .
                $op->id .
                ' data-table="print_batch_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Duplicate">' .
                '<i class="fa-solid fa-copy text-success"></i></a>';
            $delete_action =
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="print_batch_table" data-id="' .
                $op->id .
                '" id="delete_print_batch" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';

            $actions = $div_action . $update_action . $delete_action;

            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->event?->name . '</div>',
                'parking_code' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->parking->parking_code . '</div>',
                'vapp_size' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->vapp_size->title . '</div>',
                'total' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->total . '</div>',
                'printed' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->printed . '</div>',
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
        $op = new VappPrintBatch();

        $rules = [
            'parking_id' => 'required',
            'event_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'VAPP Variation created succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            $op->variation_id = $request->parking_id;
            $op->vapp_size_id = $request->vapp_size_id;
            $op->total = $request->total;
            $op->printed = $request->printed;
            // $op->match_id = $request->match_id;
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
        $op = VappPrintBatch::find($request->id);

        $rules = [
            'parking_id' => 'required',
            'event_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'VAPP Variation updated succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            $op->parking_id = $request->parking_id;
            // $op->match_id = $request->match_id;
            // $op->vapp_size_id = $request->vapp_size_id;
            $op->updated_by = $user_id;

            $op->save();

            $op->vapp_sizes()->detach();
            $op->venues()->detach();
            $op->functional_areas()->detach();
            $op->matchs()->detach();

            if ($request->fa_id) {
                foreach ($request->fa_id as $key => $data) {
                    $op->functional_areas()->attach($request->fa_id[$key]);
                }
            }

            if ($request->match_id) {
                foreach ($request->match_id as $key => $data) {
                    $op->matchs()->attach($request->match_id[$key]);
                }
            }

            if ($request->venue_id) {
                foreach ($request->venue_id as $key => $data) {
                    $op->venues()->attach($request->venue_id[$key]);
                }
            }

            if ($request->vapp_size_id) {
                foreach ($request->vapp_size_id as $key => $data) {
                    $op->vapp_sizes()->attach($request->vapp_size_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Parking updated successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        $ws = VappPrintBatch::findOrFail($id);
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
        $variation = VappPrintBatch::find($id);
        $events = Event::all();
        $parkings = ParkingMaster::all();
        $venues = Venue::all();
        $matchs = MatchList::all();
        $vapp_sizes = VappSize::all();

        $view = view('/vapp/setting/variation/mv/edit', [
            'variation' => $variation,
            'venues' => $venues,
            'matchs' => $matchs,
            'events' => $events,
            'vappSizes' => $vapp_sizes,
            'parkings' => $parkings,
        ])->render();

        return response()->json(['view' => $view]);
    }  // End function getProjectView

    public function getAssicatedVaapSizes($id)
    {
        $parkingMaster = ParkingMaster::with('vapp_sizes')->find($id);
        // $functional_areas = $parkingMaster->functional_areas;

        return response()->json(['vapp_sizes' => $parkingMaster->vapp_sizes]);
        // return response()->json(['associated_fa' => $functional_areas]);
    }  // End function getAssicatedFunctionalAreas

}
