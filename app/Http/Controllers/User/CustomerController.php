<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\Transaction;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(function ($request, $next) {
            $route_name = request()->route()->getName();
            if ($route_name == 'customers.store') {
                if (has_limit('customers', 'customer_limit') <= 0) {
                    if (!$request->ajax()) {
                        return back()->with('error', _lang('Sorry, Your have already reached your package quota !'));
                    } else {
                        return response()->json(['result' => 'error', 'message' => _lang('Sorry, Your have already reached your package quota !')]);
                    }
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $assets = ['datatable'];
        return view('backend.user.customer.list', compact('assets'));
    }

    public function get_table_data() {
        $customers = Customer::select('customers.*')
            ->orderBy("customers.id", "desc");

        return Datatables::eloquent($customers)
            ->editColumn('profile_picture', function ($customer) {
                return '<img src="' . profile_picture($customer->profile_picture) . '" class="thumb-sm img-thumbnail rounded-circle">';
            })
            ->editColumn('currency', function ($customer) {
                return $customer->currency . ' (' . currency_symbol($customer->currency) . ')';
            })
            ->addColumn('action', function ($customer) {
                return '<div class="dropdown text-center">'
                . '<button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">' . _lang('Action')
                . '</button>'
                . '<div class="dropdown-menu">'
                . '<a class="dropdown-item" href="' . route('customers.edit', $customer['id']) . '"><i class="ti-pencil"></i> ' . _lang('Edit') . '</a>'
                . '<a class="dropdown-item" href="' . route('customers.show', $customer['id']) . '"><i class="ti-eye"></i>  ' . _lang('Details') . '</a>'
                . '<form action="' . route('customers.destroy', $customer['id']) . '" method="post">'
                . csrf_field()
                . '<input name="_method" type="hidden" value="DELETE">'
                . '<button class="dropdown-item btn-remove" type="submit"><i class="ti-trash"></i> ' . _lang('Delete') . '</button>'
                    . '</form>'
                    . '</div>'
                    . '</div>';
            })
            ->setRowId(function ($customer) {
                return "row_" . $customer->id;
            })
            ->rawColumns(['profile_picture', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $alert_col = 'col-lg-8 offset-lg-2';
        if (!$request->ajax()) {
            return view('backend.user.customer.create', compact('alert_col'));
        } else {
            return view('backend.user.customer.modal.create', compact('alert_col'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|max:50',
            'email'           => [
                'nullable',
                'email',
                Rule::unique('customers')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->activeBusiness->user_id)
                        ->where('business_id', $request->activeBusiness->id);
                }),
            ],
            'currency'        => 'required',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.create')
                ->withErrors($validator)
                ->withInput();
        }

        $profile_picture = 'default.png';
        if ($request->hasfile('profile_picture')) {
            $file            = $request->file('profile_picture');
            $profile_picture = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile/", $profile_picture);
        }

        $customer               = new Customer();
        $customer->name         = $request->input('name');
        $customer->company_name = $request->input('company_name');
        $customer->email        = $request->input('email');
        $customer->mobile          = $request->input('mobile');
        $customer->country         = $request->input('country');
        $customer->currency        = $request->input('currency');
        $customer->vat_id          = $request->input('vat_id');
        $customer->reg_no          = $request->input('reg_no');
        $customer->city            = $request->input('city');
        $customer->state           = $request->input('state');
        $customer->zip             = $request->input('zip');
        $customer->address         = $request->input('address');
        $customer->remarks         = $request->input('remarks');
        $customer->profile_picture = $profile_picture;

        $customer->save();

        if (!$request->ajax()) {
            return redirect()->route('customers.index')->with('success', _lang('Saved Successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Saved Successfully'), 'data' => $customer, 'table' => '#customers_table']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data             = array();
        $data['alert_col'] = 'col-lg-10 offset-lg-1';
        $data['customer'] = Customer::find($id);

        if (!isset($_GET['tab'])) {
            $data['invoice'] = Invoice::selectRaw('COUNT(id) as total_invoice, SUM(grand_total) as total_amount, sum(paid) as total_paid')
                ->where('customer_id', $id)
                ->where('is_recurring', 0)
                ->where('status', '!=', 0)
                ->where('status', '!=', 99)
                ->first();
        }

        if (isset($_GET['tab']) && $_GET['tab'] == 'invoices') {
            $data['invoices'] = Invoice::where('customer_id', $id)
                ->where('is_recurring', 0)
                ->orderBy('invoice_date', 'desc')
                ->paginate(15);
            $data['invoices']->withPath('?tab=' . $_GET['tab']);
        }

        if (isset($_GET['tab']) && $_GET['tab'] == 'quotations') {
            $data['quotations'] = Quotation::where('customer_id', $id)
                ->orderBy('quotation_date', 'desc')
                ->paginate(15);
            $data['quotations']->withPath('?tab=' . $_GET['tab']);
        }

        if (isset($_GET['tab']) && $_GET['tab'] == 'transactions') {
            $data['transactions'] = Transaction::where('ref_id', '!=', null)
                ->where('ref_type', 'invoice')
                ->whereHas('invoice', function ($query) use ($id) {
                    return $query->where('customer_id', $id);
                })
                ->orderBy('trans_date', 'desc')
                ->paginate(15);
            $data['transactions']->withPath('?tab=' . $_GET['tab']);
        }

        return view('backend.user.customer.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $alert_col = 'col-lg-10 offset-lg-1';
        $customer  = Customer::find($id);
        return view('backend.user.customer.edit', compact('customer', 'id', 'alert_col'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|max:50',
            'email'           => [
                'nullable',
                'email',
                Rule::unique('customers')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->activeBusiness->user_id)
                        ->where('business_id', $request->activeBusiness->id);
                })->ignore($id),
            ],
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasfile('profile_picture')) {
            $file            = $request->file('profile_picture');
            $profile_picture = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile/", $profile_picture);
        }

        $customer               = Customer::find($id);
        $customer->name         = $request->input('name');
        $customer->company_name = $request->input('company_name');
        $customer->email        = $request->input('email');
        $customer->mobile  = $request->input('mobile');
        $customer->country = $request->input('country');
        $customer->vat_id  = $request->input('vat_id');
        $customer->reg_no  = $request->input('reg_no');
        $customer->city    = $request->input('city');
        $customer->state   = $request->input('state');
        $customer->zip     = $request->input('zip');
        $customer->address = $request->input('address');
        $customer->remarks = $request->input('remarks');
        if ($request->hasfile('profile_picture')) {
            $customer->profile_picture = $profile_picture;
        }

        $customer->save();

        if (!$request->ajax()) {
            return redirect()->route('customers.index')->with('success', _lang('Updated Successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Updated Successfully'), 'data' => $customer, 'table' => '#customers_table']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', _lang('Deleted Successfully'));
    }
}