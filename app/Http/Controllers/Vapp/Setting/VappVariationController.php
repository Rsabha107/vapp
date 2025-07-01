<?php

namespace App\Http\Controllers\Vapp\Setting;

use App\Http\Controllers\Controller;
use App\Models\Vapp\DeliveryRsp;
use App\Models\Vapp\Venue;
use App\Models\Vapp\VappVariation;
use App\Models\Vapp\VehicleType;
use App\Models\Vapp\Event;
use App\Models\Vapp\FunctionalArea;
use App\Models\Vapp\MatchCategory;
use App\Models\Vapp\MatchList;
use App\Models\Vapp\ParkingMaster;
use App\Models\Vapp\VappInventory;
use App\Models\Vapp\VappSize;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// use Illuminate\Support\Facades\Redirect;

class VappVariationController extends Controller
{
    //
    public function index()
    {
        $events = Event::all();
        $venues = Venue::all();
        $matchs = MatchList::all()->sortBy('match_code');
        $parkings = ParkingMaster::with('functional_areas')->get();
        $vapp_sizes = VappSize::all();
        $match_categories = MatchCategory::all();
        $functional_areas = FunctionalArea::all();

        $p1Venues = Venue::whereHas('vapp_variations', function ($q) {
            $q->where('parking_id', '6');
        })->distinct()->get();

        $parking_code = ParkingMaster::whereHas('vapp_variations', function ($q) {
            $q->where('event_id', '4');
        })->distinct()->get();

        Log::info('Parking Code: ' . $parking_code);
        Log::info($parking_code->toArray());

        $vardist = ParkingMaster::whereHas('vapp_variations')->distinct()->get();

        Log::info('var distinct:' . $vardist);
        Log::info($vardist->toArray());

        Log::info('P1 Venues:' . $p1Venues);
        Log::info($p1Venues->toArray());
        // dd($p1Venues);
        // Log::info('P1 Venues: ' . $p1Venues->toJson());
        // Log::info('P1 Venues: ' . json_encode($p1Venues));
        //
        // dd($p1Venues);

        // dd($parkings);
        return view('vapp.setting.variation.list', [
            'events' => $events,
            'venues' => $venues,
            'vapp_sizes' => $vapp_sizes,
            'matchs' => $matchs,
            'parkings' => $parkings,
            'match_categories' => $match_categories,
            'functional_areas' => $functional_areas,
        ]);
    }

    public function get($id)
    {
        $variation = VappVariation::findOrFail($id);
        $funcitonal_areas = $variation->functional_areas;
        $vapp_sizes = $variation->vapp_sizes;
        $venues = $variation->venues;
        $matchs = $variation->matchs;

        // get the parking master with functional areas
        $parkingMaster = ParkingMaster::with('functional_areas')->find($variation->parking_id);
        return response()->json([
            'variation' => $variation,
            'functional_areas' => $funcitonal_areas,
            'vapp_sizes' => $vapp_sizes,
            'parkingMasterSize' => $parkingMaster->vapp_sizes,
            'venues' => $venues,
            'parkingMasterFa' => $parkingMaster->functional_areas,
            'matchs' => $matchs,
        ]);
    }

    public function get_inventory_variation_info($id)
    {
        $variation = VappVariation::findOrFail($id);
        $funcitonal_areas = $variation->functional_areas;
        $vapp_sizes = $variation->vapp_sizes()->select('vapp_sizes.id', 'vapp_sizes.title')->get();
        $venues = $variation->venues;
        $matchs = $variation->matchs;

        return response()->json([
            'variation' => $variation,
            'functional_areas' => $funcitonal_areas,
            'vapp_sizes' => $vapp_sizes,
            'venues' => $venues,
            'matchs' => $matchs,
        ]);
    }

    public function list()
    {
        // Log::info('inside Admin VappVariationController::list');
        // Log::info(request()->all());

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $mds_schedule_event_filter = (request()->mds_schedule_event_filter) ? request()->mds_schedule_event_filter : "";
        $mds_schedule_venue_filter = (request()->mds_schedule_venue_filter) ? request()->mds_schedule_venue_filter : "";
        $mds_schedule_rsp_filter = (request()->mds_schedule_rsp_filter) ? request()->mds_schedule_rsp_filter : "";
        $mds_date_range_filter = (request()->mds_date_range_filter) ? request()->mds_date_range_filter : "";


        $ops = VappVariation::orderBy($sort, $order);

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
                '<a href="javascript:void(0)" class="btn btn-sm" id="edit_parking_variation_offcanv" data-id=' . $op->id .
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
                '" id="delete_parking_variation" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="fa-solid fa-trash text-danger"></i></a></div></div>';
            $inventory_action =
                '<a href="javascript:void(0)" class="btn btn-sm" id="add_inventory_to_variation" data-id=' .
                $op->id . ' data-parking-id=' . $op->parking_id . ' data-event-id=' . $op->event_id .
                ' data-table="vapp_inventory_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Inventory">' .
                '<i class="fa-solid fa-warehouse text-success"></i></a>';

            $vapp_size_display = '';
            foreach ($op->vapp_sizes as $vapp_size) {
                $vapp_size_display .= '<div class="white-space-wrap"><span class="badge badge-pill bg-body-tertiary text-black">' . $vapp_size->title . '</span></div> ';
            }

            $venue_display = '';
            foreach ($op->venues as $venue) {
                $venue_display .= '<div class="white-space-wrap"><span class="badge badge-pill bg-body-tertiary text-black">' . $venue->title . '</span></div> ';
            }

            $fa_display = '';
            foreach ($op->functional_areas as $fa) {
                $fa_display .= '<div class="white-space-wrap"><span class="badge badge-pill bg-body-tertiary text-black">' . $fa->title . '</span></div> ';
            }

            // $match_display = '';
            // foreach ($op->matchs as $match) {
            //     $match_display .= '<span class="badge badge-pill bg-body-tertiary text-black">' . $match->match_code . '</span> ';
            // }

            $actions = $div_action . $update_action . $inventory_action . $delete_action;

            return  [
                // 'id' => $op->id,
                'id' => '<div class="align-middle white-space-wrap fs-9 ps-2">VAR-' . $op->id . '</div>',
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$venue->id. '</div>',
                'event' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->event?->name . '</div>',
                'parking_code' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->parking->parking_code . '</div>',
                'functional_area' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $fa_display . '</div>',
                'match_code' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->match_category?->title . '</div>',
                'venue' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $venue_display . '</div>',
                'vapp_size' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $vapp_size_display . '</div>',
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
        $op = new VappVariation();

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
            $op->parking_id = $request->parking_id;
            $op->match_category_id = $request->match_category_id;
            $op->created_by = $user_id;
            $op->updated_by = $user_id;

            $op->save();

            if ($request->vapp_size_id) {
                foreach ($request->vapp_size_id as $key => $data) {
                    $op->vapp_sizes()->attach($request->vapp_size_id[$key]);
                }
            }
            // if ($request->match_id) {
            //     foreach ($request->match_id as $key => $data) {
            //         $op->matchs()->attach($request->match_id[$key]);
            //     }
            // }
            if ($request->venue_id) {
                foreach ($request->venue_id as $key => $data) {
                    $op->venues()->attach($request->venue_id[$key]);
                }
            }
            if ($request->fa_id) {
                foreach ($request->fa_id as $key => $data) {
                    $op->functional_areas()->attach($request->fa_id[$key]);
                }
            }
        }

        $notification = array(
            'message'       => 'Parking created successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function inventory_store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = new VappInventory();

        $rules = [
            'parking_id' => 'required',
            'event_id' => 'required',
            'venue_id' => 'required',
            'variation_id' => 'required',
            'vapp_size_id' => 'required',
            'total_vaps' => 'required|numeric|min:0',
            'printed_vaps' => 'required|numeric|min:0',
            'parking_id' => [
                Rule::unique('vapp_inventories')->where(function ($query) use ($request) {
                    return $query->where('parking_id', $request->parking_id)
                        ->where('event_id', $request->event_id)
                        ->where('venue_id', $request->event_id)
                        ->where('variation_id', $request->variation_id)
                        ->where('vapp_size_id', $request->vapp_size_id);
                }),
            ],
        ];

        $message = ['parking_id.unique' => 'This VAPP Inventory already exists for this Parking, Event, Variation and VAPP Size.'];
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            $error = true;
            $message = implode($validator->errors()->all('<div>:message</div>'));  // use this for json/jquery
        } else {

            $error = false;
            $message = 'VAPP Inventroy created succesfully.' . $op->id;

            $op->event_id = $request->event_id;
            $op->venue_id = $request->venue_id;
            $op->parking_id = $request->parking_id;
            $op->variation_id = $request->variation_id;
            $op->vapp_size_id = $request->vapp_size_id;
            $op->total_vaps = $request->total_vaps;
            $op->printed_vaps = $request->printed_vaps;
            $op->active_flag = 1;
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
        $op = VappVariation::find($request->id);

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
            $op->match_category_id = $request->match_category_id;
            // $op->match_id = $request->match_id;
            // $op->vapp_size_id = $request->vapp_size_id;
            $op->updated_by = $user_id;

            $op->save();

            $op->vapp_sizes()->detach();
            $op->venues()->detach();
            $op->functional_areas()->detach();
            // $op->matchs()->detach();

            if ($request->fa_id) {
                foreach ($request->fa_id as $key => $data) {
                    $op->functional_areas()->attach($request->fa_id[$key]);
                }
            }

            // if ($request->match_id) {
            //     foreach ($request->match_id as $key => $data) {
            //         $op->matchs()->attach($request->match_id[$key]);
            //     }
            // }

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
        $ws = VappVariation::findOrFail($id);
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
        $variation = VappVariation::find($id);
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

    public function getAssicatedFunctionalAreas($id)
    {
        $parkingMaster = ParkingMaster::with('functional_areas')
            ->with('vapp_sizes')->find($id);
        // $functional_areas = $parkingMaster->functional_areas;

        return response()->json([
            'functional_areas' => $parkingMaster->functional_areas,
            'vapp_sizes' => $parkingMaster->vapp_sizes,
        ]);
        // return response()->json(['associated_fa' => $functional_areas]);
    }  // End function getAssicatedFunctionalAreas

    public function getParkingCodeFromEvent($id)
    {
        $parkingMaster = ParkingMaster::where('event_id', $id)->get();
        // $functional_areas = $parkingMaster->functional_areas;

        return response()->json([
            'parkings' => $parkingMaster,
            // 'vapp_sizes' => $parkingMaster->vapp_sizes,
        ]);
        // return response()->json(['associated_fa' => $functional_areas]);
    }  // End function getParkingCodeFromEvent


}
