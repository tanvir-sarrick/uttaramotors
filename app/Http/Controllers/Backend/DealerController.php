<?php

namespace App\Http\Controllers\Backend;

use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DealerController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        abort_unless($this->user->can('dealer.manage'), 403, 'Unauthorized');
        try {
            $dealers = Dealer::query()->orderBy('created_at', 'desc');

            $dealers = $dealers->paginate(2);

            if ($request->ajax()) {
                $data = view('backend.pages.dealer.showDealerList', compact('dealers'))->render();
                return response()->json(['data' => $data]);
            }

            return view('backend.pages.dealer.index', compact('dealers'));
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }

    public function loadMoreDealer(Request $request)
    {
        abort_unless($this->user->can('dealer.manage'), 403, 'Unauthorized');
        try {
            $query = Dealer::orderBy('created_at', 'desc');

            if ($request->filled('filterData')) {
                $data = $request->input('filterData');

                $query->where(
                    fn($q) => $q
                        ->where('dealer_code', 'like', "%$data%")
                        ->orWhere('dealer_name', 'like', "%$data%")
                );
            }

            if ($request->filled('status')) {
                $status = (int) $request->input('status');

                if ($status !== 2) {
                    $query->where('status', $status);
                }
            }

            $dealers = $query->paginate(2);

            $data = view('backend.pages.dealer.showDealerList', compact('dealers'))->render();

            return response()->json([
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $e->getMessage(),
            ]);
        }
    }

    public function filterDealerData(Request $request)
    {
        abort_unless($this->user->can('dealer.manage'), 403, 'Unauthorized');
        try {
            $query = Dealer::orderBy('created_at', 'desc');

            if ($request->filled('filterData')) {
                $data = $request->input('filterData');
                $query->where(
                    fn($q) => $q
                        ->where('dealer_code', 'like', "%$data%")
                        ->orWhere('dealer_name', 'like', "%$data%")
                );
            }


            if ($request->filled('status')) {
                $status = (int) $request->input('status');

                if ($status !== 2) {
                    $query->where('status', $status);
                }
            }

            $dealers = $query->paginate(2);

            $data = view('backend.pages.dealer.showDealerList', compact('dealers'))->render();

            return response()->json([
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $e->getMessage(),
            ]);
        }
    }

    public function create()
    {
        abort_unless($this->user->can('dealer.create'), 403, 'Unauthorized');
        return view('backend.pages.dealer.create');
    }

    public function store(Request $request)
    {
        abort_unless($this->user->can('dealer.create'), 403, 'Unauthorized');
        // Validation with default messages
        $validator = Validator::make($request->all(), [
            'dealer_code'  => 'required|max:50|unique:dealers,dealer_code',
            'dealer_name'  => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create and save dealer
        $dealer = new Dealer();
        $dealer->dealer_code = $request->dealer_code;
        $dealer->dealer_name = $request->dealer_name;
        $dealer->status      = $request->status;
        $dealer->save();

        return redirect()->route('dashboard.dealer.index')->with('success', 'Dealer created successfully.');
    }

    public function edit($id)
    {
        abort_unless($this->user->can('dealer.edit'), 403, 'Unauthorized');
        $dealer = Dealer::find($id);

        if (!is_null($dealer)) {
            return view('backend.pages.dealer.edit', compact('dealer'));
        }
    }

    public function update(Request $request, $id)
    {
        abort_unless($this->user->can('dealer.edit'), 403, 'Unauthorized');
        $dealer = Dealer::findOrFail($id);

        // Validate only relevant fields
        $validator = Validator::make($request->all(), [
            'dealer_code'  => 'required|max:50|unique:dealers,dealer_code,' . $dealer->id,
            'dealer_name'  => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user
        $dealer->dealer_code = $request->dealer_code;
        $dealer->dealer_name = $request->dealer_name;
        $dealer->status      = $request->status;

        $dealer->save();

        return redirect()->route('dashboard.dealer.index')->with('success', 'Dealer updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        abort_unless($this->user->can('dealer.delete'), 403, 'Unauthorized');
        $dealer = Dealer::findOrFail($id);
        //dd($user);
        if (!is_null($dealer)) {
            if ($dealer->status === 1) {
                $status = 0;
                $dealer->update([
                    'status' => $status,
                    // 'updated_by' => Auth::id(),
                ]);

                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    "message" => "This dealer has been softdeleted successfully",
                    "url" => route('dashboard.dealer.index')
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'status' => 'warning',
                    "message" => "This user has already been softdeleted!",
                    "url" => route('dashboard.dealer.index')
                ]);
            }
        } else {
            return response()->json([
                "message" => "No Dealer found for the specified ID.",
                "url" => route('dashboard.dealer.index')
            ]);
        }
    }
}
