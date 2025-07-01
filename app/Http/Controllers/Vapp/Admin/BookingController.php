<?php

namespace App\Http\Controllers\Vapp\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vapp\BookingSlot;
use App\Models\Vapp\FunctionalArea;
use App\Models\Vapp\DeliveryBooking;
use App\Models\Vapp\DeliveryCargoType;
use App\Models\Vapp\DeliveryRsp;
// use App\Models\Vapp\DeliverySchedule;
// use App\Models\Vapp\DeliverySchedulePeriod;
use App\Models\Vapp\DeliveryType;
use App\Models\Vapp\DeliveryVehicle;
use App\Models\Vapp\DeliveryVehicleType;
use App\Models\Vapp\Venue;
use App\Models\Vapp\DeliveryZone;
use App\Models\Vapp\VappDriver;
use App\Models\Vapp\Event;
use App\Models\Vapp\MatchCategory;
use App\Models\Vapp\MatchList;
use App\Models\Vapp\ParkingMaster;
use App\Models\Vapp\VappInventory;
use App\Models\Vapp\VappRequest;
use App\Models\Vapp\VappRequestStatus;
use App\Models\Vapp\VappSize;
use App\Models\Vapp\VappVariation;
use App\Models\Vapp\VehicleType;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(session()->get('EVENT_ID'));
        // dd(session()->get('EVENT_ID'));
        // if (session()->has('EVENT_ID')) {
        //     $current_event_id = session()->get('EVENT_ID');
        //     $bookings = DeliveryBooking::where('event_id', '=', $current_event_id)->get();
        // } else {
        //     return view('vapp.admin.booking.pick');
        // }

        // $current_event_id = session()->get('EVENT_ID');

        // $bookings = DeliveryBooking::where('event_id', '=', $current_event_id)->get();
        // $bookings = DeliveryBooking::all();
        // $intervals = DeliverySchedulePeriod::all();
        $events = Event::all();
        $venues = Venue::all();
        $statuses = VappRequestStatus::all();
        $variations = VappVariation::all();
        $parkings = ParkingMaster::all();
        $vapp_sizes = VappSize::all();
        $fas = FunctionalArea::all();

        return view('vapp.admin.booking.list', [
            'events' => $events,
            'venues' => $venues,
            'statuses' => $statuses,
            'parkings' => $parkings,
            'vapp_sizes' => $vapp_sizes,
            'variations' => $variations,
            'fas' => $fas
        ]);
    }

    public function dashboard()
    {
        return view('vapp.admin.dashboard.index');
    }

    public function list()
    {
        // Log::info('inside Admin BookingController::list');
        // Log::info(request()->all());

        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $event_filter = (request()->event_filter) ? request()->event_filter : "";
        $venue_filter = (request()->venue_filter) ? request()->venue_filter : "";
        $parking_filter = (request()->parking_filter) ? request()->parking_filter : "";
        $status_filter = (request()->status_filter) ? request()->status_filter : "";
        $vapp_size_filter = (request()->vapp_size_filter) ? request()->vapp_size_filter : "";
        $fa_filter = (request()->fa_filter) ? request()->fa_filter : "";
        $variation_filter = (request()->variation_filter) ? request()->variation_filter : "";
        $date_range_filter = (request()->date_range_filter) ? request()->date_range_filter : "";

        // if ($mds_date_range_filter == "") {
        //     $mds_date_range_filter = date('Y-m-d') . ' to ' . date('Y-m-d');
        // }

        // Carbon::createFromFormat('d/m/Y', $request->slot_visibility)->toDateString()

        $ops = VappRequest::orderBy($sort, $order);
        // if ($search) {
        //     $venue = $venue->where(function ($query) use ($search) {
        //         $query->where('status', 'like', '%' . $search . '%')
        //         ->orWhere('period', 'like', '%' . $search . '%')
        //         ->orWhere('period', 'like', '%' . $search . '%')
        //             ->orWhere('id', 'like', '%' . $search . '%');
        //     });
        // }
        // if (session()->has('EVENT_ID')) {
        //     $current_event_id = session()->get('EVENT_ID');
        //     $ops = $ops->where('event_id', '=', $current_event_id);
        // }

        if ($search) {

            $ops = $ops->whereHas('client', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
                // ->orWhereHas(
                //     'schedule_period',
                //     function ($query) use ($search) {
                //         $query->where('period', 'like', '%' . $search . '%');
                //     }
                // )
                ->orWhereHas(
                    'cargo',
                    function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'zone',
                    function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'status',
                    function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'driver',
                    function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'driver',
                    function ($query) use ($search) {
                        $query->where('last_name', 'like', '%' . $search . '%');
                    }
                )
                ->orWhereHas(
                    'user_name',
                    function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    }
                );
        }


        if ($event_filter) {
            $ops = $ops->where('event_id', $event_filter);
        }

        if ($venue_filter) {
            $ops = $ops->where('venue_id', $venue_filter);
        }

        if ($parking_filter) {
            $ops = $ops->where('parking_id', $parking_filter);
        }

        if ($status_filter) {
            $ops = $ops->where('request_status_id', $status_filter);
        }

        if ($variation_filter) {
            $ops = $ops->where('variation_id', $variation_filter);
        }

        if ($vapp_size_filter) {
            $ops = $ops->where('vapp_size_id', $vapp_size_filter);
        }

        if ($fa_filter) {
            $ops = $ops->where('vapp_functional_area_id', $fa_filter);
        }

        if ($date_range_filter) {
            $dates = explode('to', $date_range_filter);
            $startDate = trim($dates[0]);
            if (count($dates) > 1) {
                $endDate = trim($dates[1]);
            } else {
                $endDate = null;
            }
            if ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/y', $startDate)->toDateString();
            }
            if ($endDate) {
                $endDate = Carbon::createFromFormat('d/m/y', $endDate)->toDateString();
            }

            if ($startDate && $endDate) {
                $ops = $ops->whereBetween('request_date', [$startDate, $endDate]);
            } else if ($startDate) {
                $ops = $ops->where('request_date', '>=', $startDate);
            } else if ($endDate) {
                $ops = $ops->where('request_date', '<=', $endDate);
            }
        }

        $total = $ops->count();
        $ops = $ops->paginate(request("limit"))->through(function ($op) {

            // $location = Location::find($booking->location_id);
            $details_url = route('vapp.admin.booking.request', $op->id);

            $actions =
                // '<div class="font-sans-serif btn-reveal-trigger position-static">' .
                // '<a href="javascript:void(0)" class="btn btn-sm" id="bookingDetails" data-id="' .
                // $op->id .
                // '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="View Booking Details">' .
                // '<i class="fas fa-lightbulb text-warning"></i></a>' .
                // '<a href="' . route('vapp.admin.booking.pass.pdf', $op->id) . '"  target="_blank" class="btn btn-sm" id="generateBookingPass" data-id="' .
                // $op->id .
                // '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Generate Pass">' .
                // '<i class="fas fa-passport text-success"></i></a>' .
                '<a href="' . $details_url . '" class="btn btn-sm" id="editBooking" data-id="' .
                $op->id .
                '" data-table="bookings_table" data-bs-toggle="tooltip" data-bs-placement="right" title="Update">' .
                '<i class="fa-solid fa-pen-to-square text-primary"></i></a>' .
                '<a href="javascript:void(0)" class="btn btn-sm" data-table="bookings_table" data-id="' .
                $op->id .
                '" id="deleteBooking" data-bs-toggle="tooltip" data-bs-placement="right" title="Delete">' .
                '<i class="bx bx-trash text-danger"></i></a></div></div>';

            $order_status =  '<span class="badge badge-phoenix fs--2 badge-phoenix-' . $op->status->color . ' "><span class="badge-label" style="cursor: pointer;" id="editStatus" data-id="' . $op->id . '" data-table="bookings_table">' . $op->status->title . '</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span>';
            $approved_vapps = $op->approved_vapps ?? '0';
            return  [
                'id' => $op->id,
                // 'id' => '<div class="align-middle white-space-wrap fw-bold fs-8 ps-2">' .$op->id. '</div>',
                'request_number' => '<div class="align-middle white-space-wrap fs-9 ps-2"><a href="' . $details_url . '">' .  $op->request_number . '</a></div>',
                'event_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' .  $op->event?->name . '</div>',
                'venue_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' .  $op->venue?->short_name . '</div>',
                'variation_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">VAR-' . $op->variation_id . '</div>',
                'parking_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->parking?->parking_code . '</div>',
                'match_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->match->match_code . '</div>',
                'request_date' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . format_date($op->request_date) . '</div>',
                'functional_area_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->functional_area?->title . '</div>',
                'vapp_size_id' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->vapp_size?->title . '</div>',
                'requested_vapps' => '<div class="align-middle white-space-wrap fs-9 fw-bold ps-2">' . $op->requested_vapps . '</div>',
                'approved_vapps' => '<div class="align-middle white-space-wrap fs-9 ps-2 fw-bold text-success">' . $approved_vapps . '</div>',
                // 'requested_vapp_a5' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->requested_vapp_a5 . '</div>',
                // 'approved_vapp_a5' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->approved_vapp_a5 . '</div>',
                // 'requested_vapp_a4' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->requested_vapp_a4 . '</div>',
                // 'approved_vapp_a4' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->requested_vapp_a4 . '</div>',
                // 'requested_vapp_20' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->requested_vapp_20 . '</div>',
                // 'approved_vapp_20' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->requested_vapp_20 . '</div>',
                // 'requested_vapp_hanger' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->requested_vapp_hanger . '</div>',
                // 'approved_vapp_hanger' => '<div class="align-middle white-space-wrap fs-9 ps-2">' . $op->approved_vapp_hanger . '</div>',
                'status' => $order_status,
                'action' => $actions,
                'created_at' => format_date($op->created_at,  'H:i:s'),
                'updated_at' => format_date($op->updated_at, 'H:i:s'),
                'created_by' => $op->user_name?->name,
                'updated_by' => $op->user_name?->name,
            ];
        });

        return response()->json([
            "rows" => $ops->items(),
            "total" => $total,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $fa = $user->fa->pluck('id')->toArray();
        // $venueid = [6];
        // $fa1 = $fa->toArray();
        // $venues = BookingSlot::select('venue_id', 'venue_name')
        //     ->where('event_id', session()->get('EVENT_ID'))
        //     ->distinct()
        //     ->get();

        // pupulate the parking codes based on the functional areas
        $varParkingCode = ParkingMaster::with('functional_areas')
            ->when($fa, function ($query, $fa) {
                Log::info('inside when');
                Log::info($fa);
                $query->whereHas('functional_areas', function ($q2) use ($fa) {
                    $q2->whereIn('functional_area_id', $fa)
                        ->where('event_id', session()->get('EVENT_ID'));
                });
            })
            ->get();

        $matchCategories = MatchCategory::all();

        // Log::info('varParkingCode: ' . $varParkingCode);

        // dd($varParkingCode);
        // starting the VAPP Request
        // get the parking codes for the variations
        // $varParkingCode = ParkingMaster::whereHas('vapp_variations', function ($q) {
        //     $q->where('event_id', session()->get('EVENT_ID'));
        // })->distinct()->get();

        // $venueid = 11;
        // $venueidArr = [$venueid];
        // $varMatchCode = VappVariation::with('functional_areas', 'match_category')
        //     ->where('parking_id', '6')
        //     ->when($fa, function ($query, $fa) {
        //         Log::info('inside when');
        //         Log::info($fa);
        //         $query->whereHas('functional_areas', function ($q2) use ($fa) {
        //             $q2->whereIn('fa_id', $fa)
        //                 ->where('event_id', session()->get('EVENT_ID'));
        //         });
        //     })
        //     ->when($venueidArr, function ($query, $venueid) {
        //         Log::info('inside when');
        //         Log::info($venueid);
        //         $query->whereHas('venues', function ($q2) use ($venueid) {
        //             $q2->whereIn('venue_id', $venueid)
        //                 ->where('event_id', session()->get('EVENT_ID'));
        //         });
        //     })
        //     ->get();


        // $varMatchCategoryId = $varMatchCode->pluck('match_category_id')->toArray();
        // Log::info('varMatchCategoryId ***********************');
        // Log::info($varMatchCategoryId);
        // // dd($varMatchCode);
        // foreach ($varMatchCode as $match) {
        //     Log::info('Variation ID: ' . $match->id);
        //     Log::info('Match Category ID: ' . $match->match_category_id);
        //     Log::info('Match match category code: ' . $match->match_category->title);
        //     Log::info('Match match code: ' . $match->match_category->match_list);
        //     Log::info('Event ID: ' . $match->event_id);
        //     Log::info('Parking ID: ' . $match->parking_id);
        //     Log::info('Functional Areas: ' . $match->functional_areas);
        //     Log::info('Venues: ' . $match->venues);
        // }

        // $matchs = MatchList::where('venue_id', $venueid)
        //     ->where('event_id', session()->get('EVENT_ID'))
        //     ->whereIn('match_category_id', $varMatchCategoryId)
        //     ->get();
        // Log::info('Matchs: ***************************');
        // Log::info($matchs);

        // $variationRecord = VappVariation::where('parking_id', '6')
        //     ->where('match_category_id', '31')
        //     ->where('event_id', '4')
        //     ->with('vapp_sizes', 'venues')
        //     ->whereHas('venues', function ($q) {
        //         $q->where('venues.id', '6');
        //     })->first();

        // dd($variationRecord->vapp_sizes);
        // foreach ($variationRecord as $record) {
        //     Log::info('Variation Record: ' . $record->id);
        //     Log::info('Vapp Sizes: ' . $record->vapp_sizes);
        //     Log::info('Venues: ' . $record->venues);
        // }
        // dd($variationRecord->vapp_sizes);

        return view('vapp.admin.booking.create', compact(
            'varParkingCode',
            'matchCategories' //, 'venues', 'varMatchCode', 'varMatchCategoryId', 'matchs', 'variationRecord'
        ));
    }

    // get vairations for the parking code selected and display the match category to choose from
    public function getVariationsFromParkingCode(Request $request)
    {
        // Log::info('inside getVariationsFromParkingCode');
        // Log::info($id);
        $user = Auth::user();

        // get the variations based on the parking code and functional areas
        $variationCategory = VappVariation::with('match_category')
            ->where('parking_id', $request->parking_id)
            ->where('event_id', session()->get('EVENT_ID'))
            ->get();

        return response()->json(['variationCategory' => $variationCategory]);
    }

    //get all matches from match list if match category selected is 'MATCH' ortherwise get all matches from vapp variations based on the parking code and functional areas
    public function getMatchesFromMatchCategory(Request $request)
    {
        // Log::info('inside getMatchesFromMatchCategory');
        // Log::info($request->all());
        $user = Auth::user();
        $fas = $user->fa;
        $fa = $user->fa->pluck('id')->toArray();

        // get the match category id
        $matchCategory = MatchCategory::find($request->match_category_id);

        // get all matches from match list
        $matches = MatchList::where('event_id', session()->get('EVENT_ID'))
            ->where('match_category_id', $request->match_category_id)
            ->orderBy('match_code')
            ->get();

        Log::info('matchCategory: ' . $matchCategory->title);
        if ($matchCategory->title == 'MATCH') {
            return response()->json([
                'matches' => $matches,
                'functional_areas' => $fas,
                'variation_venues' => []
            ]);
        } elseif ($matchCategory->title == 'ALL') {

            // get all venues from vapp variations based on the parking code and functional areas
            $varVenues = Venue::whereHas('vapp_variations', function ($q) use ($request, $fa) {
                $q->where('parking_id', $request->parking_id)
                    ->where('match_category_id', $request->match_category_id)
                    ->where('event_id', session()->get('EVENT_ID'));
            })->distinct()->get();

            return response()->json(['matches' => $matches, 'functional_areas' => $fas, 'variation_venues' => $varVenues]);
        }

        return response()->json(['matches' => $matches]);
    }

    // get all venues from matches, if match category is 'MATCH' then get all venues from match list, otherwise get all venues from vapp variations based on the parking code and functional areas
    public function getVenuesFromMatch(Request $request)
    {
        // Log::info('inside getVenuesFromMatchCategory');
        // Log::info($request->all());
        $user = Auth::user();
        $fas = $user->fa;
        $fa = $user->fa->pluck('id')->toArray();

        // get the match category id
        $matchCategory = MatchCategory::find($request->match_category_id);

        // get all venues from match list
        $matches = MatchList::with('venue')
            ->where('event_id', session()->get('EVENT_ID'))
            ->where('match_category_id', $request->match_category_id)
            ->where('id', $request->match_id)
            ->get();

        Log::info('matchCategory: ' . $matchCategory->title);
        if ($matchCategory->title == 'MATCH') {
            return response()->json([
                'matches' => $matches,
                'functional_areas' => $fas
            ]);
        } elseif ($matchCategory->title == 'ALL') {

            // get all venues from vapp variations based on the parking code and functional areas
            $varVenues = Venue::whereHas('vapp_variations', function ($q) use ($request, $fa) {
                $q->where('parking_id', $request->parking_id)
                    ->where('match_category_id', $request->match_category_id)
                    ->where('event_id', session()->get('EVENT_ID'));
            })->distinct()->get();

            return response()->json(['matches' => $matches, 'functional_areas' => $fas, 'variation_venues' => $varVenues]);
        }
    }

    //get the color from parking code
    public function getParkingColor(Request $request)
    {
        // Log::info('inside getParkingColor');
        // Log::info($request->all());
        $parking = ParkingMaster::find($request->parking_id);
        if ($parking) {
            return response()->json(['parking_color' => $parking->vapp_color]);
        } else {
            return response()->json(['parking_color' => null]);
        }
    }

    // get all distinct venues from vapp variations based on the parking code
    // public function getVenuesFromVappCode($id = null)
    // {

    //     $varVenues = Venue::whereHas('vapp_variations', function ($q) use ($id) {
    //         $q->where('parking_id', $id);
    //     })->distinct()->get();

    //     return response()->json(['venues' => $varVenues]);
    // }

    // get all match codes from vapp variations based on the venue code
    // public function getMatchesFromVappVenue($id = null)
    // {
    //     $matches = MatchList::where('venue_id', $id)
    //         ->orderBy('match_code')
    //         ->get();

    //     return response()->json(['matches' => $matches]);
    // }

    public function getMatchesOfParking(Request $request)
    {

        $user = Auth::user();

        $matches = MatchList::where('parking_id', $request->parking_id)
            ->where('event_id', session()->get('EVENT_ID'))
            ->get();

        $fa = $user->fa->pluck('id')->toArray();

        $venueid = $request->venue_id;
        $venueidArr = [$venueid];

        // get the variation match codes based on the parking code and functional areas
        $varMatchCode = VappVariation::with('functional_areas', 'match_category')
            ->where('parking_id', $request->parking_id)
            ->when($fa, function ($query, $fa) {
                Log::info('inside when');
                Log::info($fa);
                $query->whereHas('functional_areas', function ($q2) use ($fa) {
                    $q2->whereIn('fa_id', $fa)
                        ->where('event_id', session()->get('EVENT_ID'));
                });
            })
            ->when($venueidArr, function ($query, $venueid) {
                Log::info('inside when');
                Log::info($venueid);
                $query->whereHas('venues', function ($q2) use ($venueid) {
                    $q2->whereIn('venue_id', $venueid)
                        ->where('event_id', session()->get('EVENT_ID'));
                });
            })
            ->get();

        $varMatchCategoryId = $varMatchCode->pluck('match_category_id')->toArray();
        $variationId = $varMatchCode->pluck('match_category_id')->toArray();

        $matches = MatchList::where('venue_id', $venueid)
            ->where('event_id', session()->get('EVENT_ID'))
            ->whereIn('match_category_id', $varMatchCategoryId)
            ->get();

        return response()->json(['matches' => $matches]);
    }

    public function getMatchesFromVappVenue(Request $request)
    {

        $user = Auth::user();
        $fa = $user->fa->pluck('id')->toArray();

        $venueid = $request->venue_id;
        $venueidArr = [$venueid];

        // get the variation match codes based on the parking code and functional areas
        $varMatchCode = VappVariation::with('functional_areas', 'match_category')
            ->where('parking_id', $request->parking_id)
            ->when($fa, function ($query, $fa) {
                Log::info('inside when');
                Log::info($fa);
                $query->whereHas('functional_areas', function ($q2) use ($fa) {
                    $q2->whereIn('fa_id', $fa)
                        ->where('event_id', session()->get('EVENT_ID'));
                });
            })
            ->when($venueidArr, function ($query, $venueid) {
                Log::info('inside when');
                Log::info($venueid);
                $query->whereHas('venues', function ($q2) use ($venueid) {
                    $q2->whereIn('venue_id', $venueid)
                        ->where('event_id', session()->get('EVENT_ID'));
                });
            })
            ->get();

        $varMatchCategoryId = $varMatchCode->pluck('match_category_id')->toArray();
        $variationId = $varMatchCode->pluck('match_category_id')->toArray();

        $matches = MatchList::where('venue_id', $venueid)
            ->where('event_id', session()->get('EVENT_ID'))
            ->whereIn('match_category_id', $varMatchCategoryId)
            ->get();

        return response()->json(['matches' => $matches]);
    }

    // get all match codes from vapp variations based on the venue code
    public function getVariation(Request $request)
    {

        $variationRecord = VappVariation::where('parking_id', $request->parking_id)
            ->where('match_category_id', $request->match_category_id)
            ->where('event_id', session()->get('EVENT_ID'))
            ->with('vapp_sizes', 'venues', 'functional_areas')
            ->whereHas('venues', function ($q) use ($request) {
                $q->where('venues.id', $request->venue_id);
            })->first();

        return response()->json(['variation' => $variationRecord]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $user_id = Auth::user()->id;
        $op = new VappRequest();
        $inventory = VappInventory::where('variation_id', $request->variation_id)
            ->where('event_id', session()->get('EVENT_ID'))
            ->first();

        $variation = VappVariation::with('inventory', 'vapp_sizes')
            ->where('id', $request->variation_id)
            ->where('event_id', session()->get('EVENT_ID'))
            ->first();

        // Log::info('BookingController::store variation: ' . $variation);
        // Log::info($variation->inventory()->where('vapp_size_id', 39)->first());
        // $timeslots = DeliverySchedulePeriod::findOrFail($request->schedule_period_id);

        $rules = [
            'parking_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $type = 'success';
            $message = 'Booking could not be created';
        } else {

            // check number of slots available.  if available slots = 0 then exit with a warning message.
            // this is incase a user grabed the last slot with this user is waiting ..

            $error = false;
            $type = 'success';
            $message = 'Request created succesfully.' . $op->id;

            Log::info($request->all());
            $op->venue_id = $request->venue_id;
            $op->parking_id = $request->parking_id;
            $op->match_id = $request->match_id;
            $op->match_category_id = $request->match_category_id;
            $op->variation_id = $request->variation_id;
            $op->vapp_size_id = $request->vapp_size_id;
            $op->vapp_functional_area_id = $request->var_functional_area_id;
            $op->requested_vapps = $request->requested_vapps;
            $op->approved_vapps = 0;
            $op->request_date = now()->toDateString();

            // // $op->requested_vapp_a5 = $request->requested_vapp_a5;
            // $request->requested_vapp_a5 ? $op->requested_vapp_a5 = $request->requested_vapp_a5 : $op->requested_vapp_a5 = 0;
            // $a5 = $variation->inventory()->where('vapp_size_id', 36)->first();
            // $a5?->update(['total_vaps' => $a5->total_vaps - $request->requested_vapp_a5]);

            // $request->requested_vapp_a4 ? $op->requested_vapp_a4 = $request->requested_vapp_a4 : $op->requested_vapp_a4 = 0;
            // $a4 = $variation->inventory()->where('vapp_size_id', 37)->first();
            // $a4?->update(['total_vaps' => $a4->total_vaps - $request->requested_vapp_a4]);

            // $request->requested_vapp_20 ? $op->requested_vapp_20 = $request->requested_vapp_20 : $op->requested_vapp_20 = 0;
            // $a20 = $variation->inventory()->where('vapp_size_id', 38)->first();
            // $a20?->update(['total_vaps' => $a20->total_vaps - $request->requested_vapp_a20]);

            // $request->requested_vapp_hanger ? $op->requested_vapp_hanger = $request->requested_vapp_hanger : $op->requested_vapp_hanger = 0;
            // $hanger = $variation->inventory()->where('vapp_size_id', 39)->first();
            // $hanger?->update(['total_vaps' => $hanger->total_vaps - $request->requested_vapp_hanger]);

            // $request->approved_vapp_a5 ? $op->approved_vapp_a5 = $request->approved_vapp_a5 : $op->approved_vapp_a5 = 0;
            // $request->approved_vapp_a4 ? $op->approved_vapp_a4 = $request->approved_vapp_a4 : $op->approved_vapp_a4 = 0;
            // $request->approved_vapp_20 ? $op->approved_vapp_20 = $request->approved_vapp_20 : $op->approved_vapp_20 = 0;
            // $request->approved_vapp_hanger ? $op->approved_vapp_hanger = $request->approved_vapp_hanger : $op->approved_vapp_hanger = 0;

            $op->justification = $request->justification;
            $op->comments = $request->comments;
            $op->request_status_id = 11; // in progress
            $op->event_id = session()->get('EVENT_ID');
            $op->created_by = $user_id;
            $op->updated_by = $user_id;
            $op->save();
        }

        $notification = array(
            'message'       => $message,
            'alert-type'    => $type
        );

        // return redirect()->route('vapp.booking.add')->with($notification);
        return redirect()->route('vapp.admin.booking')->with($notification);
        // return response()->json(['error' => $error, 'message' => $message]);
    }

    public function delete($id)
    {
        // LOG::info('inside delete');
        $op = VappRequest::find($id);

        // $variation = VappVariation::with('inventory', 'vapp_sizes')
        //     ->where('id', $op->variation_id)
        //     ->where('event_id', session()->get('EVENT_ID'))
        //     ->first();

        // $a5 = $variation->inventory()->where('vapp_size_id', 36)->first();
        // $a5?->update(['total_vaps' => $a5->total_vaps + $op->requested_vapp_a5]);

        // $a4 = $variation->inventory()->where('vapp_size_id', 37)->first();
        // $a4?->update(['total_vaps' => $a4->total_vaps + $op->requested_vapp_a4]);

        // $a20 = $variation->inventory()->where('vapp_size_id', 38)->first();
        // $a20?->update(['total_vaps' => $a20->total_vaps + $op->requested_vapp_a20]);

        // $hanger = $variation->inventory()->where('vapp_size_id', 39)->first();
        // $hanger?->update(['total_vaps' => $hanger->total_vaps + $op->requested_vapp_hanger]);

        $op->delete();

        $error = false;
        $message = 'Request deleted succesfully.';

        $notification = array(
            'message'       => 'Booking deleted successfully',
            'alert-type'    => 'success'
        );

        return response()->json(['error' => $error, 'message' => $message]);
        // return redirect()->route('tracki.setup.workspace')->with($notification);
    } // delete

    public function editStatus($id)
    {
        //  dd('editTaskProgress');
        $data = VappRequest::find($id);
        //dd($data);
        $data_arr = [];

        $data_arr[] = [
            "id"        => $data->id,
            "status_id"  => $data->request_status_id,
        ];

        $response = ["retData"  => $data_arr];
        return response()->json($response);
    } // editStatus

    public function updateStatus(Request $request)
    {

        $head = VappRequest::findOrFail($request->id);
        $status_title = VappRequestStatus::findOrFail($request->status_id);

        Log::info($status_title->title);
        $head->update([
            'request_status_id' => $request->status_id,
        ]);

        $notification = array(
            'message'       => 'Request status updated successfully',
            'alert-type'    => 'success'
        );

        // if ($status_title->title == 'Payment Pending') {
        //     $saveOrderPdf = $this->saveOrderPDF($head->id);

        //     $details = [
        //         'email' => 'rsabha@gmail.com',
        //         'order_ref_number' => $head->order_number,
        //         'filename' => $head->order_number . '.pdf',
        //     ];

        //     Log::info('BookingController::admin_email: ' . config('settings.admin_email'));
        //     Log::info('BookingController::store details: ' . json_encode($details));
        //     Log::info('BookingController::store settings.send_notifications: ' . config('settings.send_notifications'));

        //     if (config('settings.send_notifications')) {
        //         SendNewOrderEmailJob::dispatch($details);
        //     }
        // }

        return response()->json(['error' => false, 'message' => 'Order Status updated successfully.', 'id' => $head->id]);
    } //updateStatus

    /**
     * Display the specified resource.
     */
    public function showRequest(string $id)
    {

        Log::info('BookingController::showRequest id: ' . $id);
        $vapp = VappRequest::findOrFail($id);
        // dd($vapp);
        $requestStatus = VappRequestStatus::all();
        // dd($op);
        Log::info('BookingController::showRequest vapp: ' . json_encode($vapp));
        $variation = VappVariation::with('inventory', 'vapp_sizes')
            ->where('id', $vapp->variation_id)
            ->where('venue_id', $vapp->venue_id)
            // ->where('event_id', session()->get('EVENT_ID'))
            ->where('event_id', $vapp->event_id)
            ->first();

        Log::info('BookingController::showRequest variation: ' . $variation);

        $inventory = VappInventory::where('variation_id', $vapp->variation_id)
            // ->where('event_id', session()->get('EVENT_ID'))
            ->where('event_id', $vapp->event_id)
            ->where('venue_id', $vapp->venue_id)
            ->where('parking_id', $vapp->parking_id)
            ->where('vapp_size_id', $vapp->vapp_size_id)
            ->first();

        $inventory_collected_vaps = get_totals($vapp->event_id, $vapp->venue_id, $vapp->vapp_size_id, $vapp->parking_id, $vapp->variation_id, 'Collected');
        $inventory_rfc_vaps = get_totals($vapp->event_id, $vapp->venue_id, $vapp->vapp_size_id, $vapp->parking_id, $vapp->variation_id, 'Ready for Collection');

        // dd($collected_vaps, $rfc_vaps);
        $inv_total_collected_vaps = $inventory_collected_vaps + $inventory_rfc_vaps;
        $inv_total_available_vaps = $inventory->printed_vaps - $inv_total_collected_vaps;

        $capacity = get_totals_capacity($vapp->event_id, $vapp->venue_id,  $vapp->vapp_size_id,  $vapp->parking_id, $vapp->variation_id, 'c');
        $approved = get_totals($vapp->event_id, $vapp->venue_id,  $vapp->vapp_size_id,  $vapp->parking_id, $vapp->variation_id, 'Approved');
        $rfc = get_totals($vapp->event_id, $vapp->venue_id,  $vapp->vapp_size_id,  $vapp->parking_id, $vapp->variation_id, 'Ready for Collection');
        $collected = get_totals($vapp->event_id, $vapp->venue_id,  $vapp->vapp_size_id,  $vapp->parking_id, $vapp->variation_id, 'Collected');

        $total_approved_capacity = $approved + $rfc + $collected;
        $available_capacity = $capacity - $total_approved_capacity;
        // Log::info('BookingController::showRequest variation: ' . $variation);

        return view('vapp.admin.booking.request', compact(
            'vapp',
            'variation',
            'capacity',
            'total_approved_capacity',
            'available_capacity',
            'inventory',
            'inv_total_collected_vaps',
            'inv_total_available_vaps',
            'requestStatus',
        ));
    }

    public function saveRequest(Request $request)
    {
        // dd($request);
        $user_id = Auth::user()->id;
        $op = VappRequest::find($request->id);

        $rules = [
            'approved_vapps' => 'required',
            'request_status_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $type = 'error';
            $message = 'Booking could not be updated';
        } else {

            $error = false;
            $type = 'success';
            $message = 'Booking updated succesfully.' . $op->id;

            Log::info('BookingController::saveRequest: ' . json_encode($request->all()));

            $op->approved_vapps = $request->approved_vapps;
            $op->request_status_id = $request->request_status_id;
            // $op->updated_by = $user_id;
            $op->save();
        }

        return redirect()->route('vapp.admin.booking')->with([
            'error' => $error,
            'message' => $message,
            'type' => $type
        ]);

        return response()->json(['error' => $error, 'message' => $message]);
    } //

    public function detail($id)
    {
        $booking = DeliveryBooking::findOrFail($id);

        // dd($project);

        // Log::alert('EmployeeController::getEmpEditView file_name: ' . $emp->emp_files?->file_name);

        $view = view('/vapp/admin/booking/mv/detail', [
            'booking' => $booking,
        ])->render();

        return response()->json(['view' => $view]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = DeliveryBooking::find($id);
        // $intervals = DeliverySchedulePeriod::all();
        $venues = Venue::all();
        $rsps = DeliveryRsp::all();
        $drivers = VappDriver::all();
        $vehicles = DeliveryVehicle::all();
        $vehicle_types = DeliveryVehicleType::all();
        $delivery_types = DeliveryType::all();
        $cargos = DeliveryType::all();
        $loading_zones = DeliveryZone::all();
        $clients = FunctionalArea::all();

        return view('vapp.admin.booking.edit', compact(
            'booking',
            // 'intervals',
            'venues',
            'rsps',
            'drivers',
            'vehicles',
            'vehicle_types',
            'delivery_types',
            'cargos',
            'loading_zones',
            'clients'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        //  dd($request);
        $user_id = Auth::user()->id;
        $booking = DeliveryBooking::find($request->id);
        $timeslots = BookingSlot::findOrFail($request->schedule_period_id);

        // dd($booking);
        $rules = [
            'booking_date' => 'required',
            'schedule_period_id' => 'required',
            'venue_id' => 'required',
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'vehicle_type_id' => 'required',
            'receiver_name' => 'required',
            'receiver_contact_number' => 'required',
            'dispatch_id' => 'required',
            'cargo_id' => 'required',
            'loading_zone_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info($validator->errors());
            $error = true;
            $type = 'error';
            $message = 'Booking could not be created';
        } else {

            // check number of slots available.  if available slots = 0 then exit with a warning message.
            // this is incase a user grabed the last slot with this user is waiting ..

            if ($timeslots->available_slots > 0) {

                $error = false;
                $type = 'success';
                $message = 'Booking updated succesfully.' . $booking->id;

                Log::info('booking->schedule_period_id: ' . $booking->schedule_period_id);
                Log::info('request->schedule_period_id: ' . $request->schedule_period_id);

                if ($request->schedule_period_id != $booking->schedule_period_id) {
                    Log::info('booking->schedule_period_id: ' . $booking->schedule_period_id);
                    Log::info('request->schedule_period_id: ' . $request->schedule_period_id);

                    $timeslots->available_slots = $timeslots->available_slots - 1;
                    $timeslots->used_slots = $timeslots->used_slots + 1;

                    $old_timeslot = BookingSlot::findOrFail($booking->schedule_period_id);
                    $old_timeslot->available_slots = $old_timeslot->available_slots + 1;
                    $old_timeslot->used_slots = $old_timeslot->used_slots - 1;
                } else {
                    $timeslots->available_slots = $timeslots->available_slots;
                    $timeslots->used_slots = $timeslots->used_slots;
                }

                // $booking->booking_ref_number = 'MDS' . $booking->id;
                // $booking->schedule_id =  $timeslots->delivery_schedule_id;
                $booking->schedule_period_id = $request->schedule_period_id;
                // $booking->booking_date = Carbon::createFromFormat('Y/m/d', $request->booking_date)->toDateString();
                $booking->booking_date = $request->booking_date;
                $booking->venue_id = $request->venue_id;
                $booking->client_id = $request->client_id;
                $booking->rsp_id = $timeslots->rsp_id;
                $booking->booking_party_company_name = $request->booking_party_company_name;
                $booking->booking_party_contact_name = $request->booking_party_contact_name;
                $booking->booking_party_contact_email = $request->booking_party_contact_email;
                $booking->booking_party_contact_number = $request->booking_party_contact_number;
                // $booking->delivering_party_company_name = $request->delivering_party_company_name;
                // $booking->delivering_party_contact_number = $request->delivering_party_contact_number;
                // $booking->delivering_party_contact_email = $request->delivering_party_contact_email;
                $booking->driver_id = $request->driver_id;
                $booking->vehicle_id = $request->vehicle_id;
                $booking->vehicle_type_id = $request->vehicle_type_id;
                $booking->receiver_name = $request->receiver_name;
                $booking->receiver_contact_number = $request->receiver_contact_number;
                $booking->dispatch_id = $request->dispatch_id;
                $booking->loading_zone_id = $request->loading_zone_id;
                $booking->cargo_id = $request->cargo_id;
                $booking->active_flag = $request->active_flag;
                $booking->created_by = $user_id;
                $booking->updated_by = $user_id;
                $booking->active_flag = 1;

                $timeslots->save();
                if (isset($old_timeslot)) {
                    $old_timeslot->save();
                }
                $booking->save();
            } else {
                $error = true;
                $type = 'error';
                $message = 'Time slot choosing has been used. please choose a different time slot.' . $booking->id;
            }
        }

        $notification = array(
            'message'       => $message,
            'alert-type'    => $type
        );

        return redirect()->route('vapp.admin.booking')->with($notification);
        // return view('vapp.admin.booking');


        // return response()->json(['error' => $error, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function passPdf(Request $request, $id)
    {
        // set_time_limit(300);
        $booking = DeliveryBooking::findOrFail($id);
        $qr_code = getQrCode($booking->id, 100);


        $data = [
            'to' => 'Sam Example',
            'subtotal' => '5.00',
            'tax' => '.35',
            'total' => '5.35',
            'receipeint_company' => 'GWC Logistics',
            'booking' => $booking,
            'qr_code' => $qr_code,

        ];

        if ($request->has('preview')) {
            $data['css'] = asset('assets/css/invoice.css');
            return view('vapp.booking.passx', $data);
        } else {
            $data['css'] = public_path('assets/css/invoice.css');
        }

        // Pdf::view('vapp.booking.passx');
        // Pdf::view('vapp.booking.passx')->save('/upload/passx.pdf');
        // return view('vapp.booking.passx', $data);
        $pdf = Pdf::loadView('vapp.admin.booking.passx', $data);
        // return $pdf->download('itsolutionstuff.pdf');
        return $pdf->stream();
    }  //taskDetailsPDF

    // public function get_times($date, $venue_id)
    // {
    //     // LOG::info('inside get_times');
    //     $formated_date = Carbon::createFromFormat('dmY', $date)->toDateString();
    //     // LOG::info('formated_date: '.$formated_date);
    //     // LOG::info('venue_id: '.$venue_id);
    //     // $venue = DeliverySchedulePeriod::where('period_date', '=', $formated_date)
    //     //     ->where('venue_id', '=', $venue_id)
    //     //     // ->where('available_slots', '>', '0')
    //     //     ->get();

    //     // $venue = DeliverySchedulePeriod::all();

    //     // return response()->json(['venue' => $venue]);
    // }

    public function switch($id)
    {
        if ($id) {
            if (Event::findOrFail($id)) {
                Log::info('Event ID: ' . $id);

                session()->put('EVENT_ID', $id);
                Log::info('Event ID: ' . session()->get('EVENT_ID'));
                // return redirect()->route('tracki.project.show.card')->with('message', 'Workspace switched successfully.');
                return redirect()->route('vapp.admin.booking')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            } else {
                // return back()->with('error', 'Workspace not found.');
                // return redirect()->route('tracki.project.show.card')->with('error', 'Workspace not found.');
                return back()->with('error', 'Event not found.');
            }
        } else {
            session()->forget('EVENT_ID');
            // return redirect()->route('tracki.project.show.card')->with('message', 'Workspace switched successfully. now showing all workspace data');
            return back()->withInput();
        }
    }

    public function pickEvent(Request $request)
    {
        // $events = Event::all();
        // $this->switch($request->event_id);
        // return view('vapp.admin.booking.pick', compact('events'));
        if ($request->event_id) {
            Log::info('Event ID: ' . $request->event_id);
            if (Event::findOrFail($request->event_id) && !session()->has('EVENT_ID')) {
                Log::info('Inside if statement Event ID: ' . $request->event_id);

                session()->put('EVENT_ID', $request->event_id);
                Log::info('session EVENT_ID: ' . session()->get('EVENT_ID'));
                Log::info('before redirect');
                // return redirect()->route('tracki.project.show.card')->with('message', 'Workspace switched successfully.');
                return redirect()->route('vapp.admin.booking')->with('message', 'Event Switched.');
                // return back()->with('message', 'Event Switched.');
            }
        }
        //  else {
        // return back()->with('error', 'Workspace not found.');
        // return redirect()->route('tracki.project.show.card')->with('error', 'Workspace not found.');
        Log::info('event_id is null');
        return redirect()->route('vapp.admin.booking')->with('error', 'Event not found.');
        // }
    }
}
