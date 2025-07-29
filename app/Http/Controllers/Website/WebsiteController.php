<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\Models\ContactMessage;
use App\Models\EmailSubscriber;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Page;
use App\Models\Post;
use App\Models\Team;
use App\Models\Testimonial;
use App\Utilities\Overrider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class WebsiteController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        if (env('APP_INSTALLED', true) == true) {
            date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
            $this->middleware(function ($request, $next) {
                if (isset($_GET['language'])) {
                    session(['language' => $_GET['language']]);
                    return back();
                }
                if (get_option('website_enable', 1) == 0) {
                    return redirect()->route('login');
                }
                return $next($request);
            });
        }
    }

    /**
     * Display website's home page
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = '') {
        $data = [];

        if ($slug != '') {
            $page = Page::where('slug', $slug)->where('status', 1)->first();
            if (! $page) {
                abort(404);
            }
            return view('website.page', compact('page'));
        }

        $data['pageData']  = json_decode(get_trans_option('home_page'));
        $data['pageMedia'] = json_decode(get_trans_option('home_page_media'));
        if (isset($data['pageData']->title)) {
            $data['page_title'] = $data['pageData']->title;
        }
        $data['features']     = Feature::active()->get();
        $data['packages']     = Package::active()->get();
        $data['blog_posts']   = Post::active()->limit(3)->orderBy('id', 'desc')->get();
        $data['testimonials'] = Testimonial::all();

        return view('website.index', $data);
    }

    public function about() {
        $data               = [];
        $data['pageData']   = json_decode(get_trans_option('about_page'));
        $data['pageMedia']  = json_decode(get_trans_option('about_page_media'));
        $data['page_title'] = isset($data['pageData']->title) ? $data['pageData']->title : '';

        $data['team_members'] = Team::all();
        return view('website.about', $data);
    }

    public function features() {
        $data               = [];
        $data['pageData']   = json_decode(get_trans_option('features_page'));
        $data['pageMedia']  = json_decode(get_trans_option('features_page_media'));
        $data['page_title'] = isset($data['pageData']->title) ? $data['pageData']->title : '';

        $data['features'] = Feature::all();
        return view('website.features', $data);
    }

    public function pricing() {
        $data               = [];
        $data['pageData']   = json_decode(get_trans_option('pricing_page'));
        $data['pageMedia']  = json_decode(get_trans_option('pricing_page_media'));
        $data['page_title'] = isset($data['pageData']->title) ? $data['pageData']->title : '';

        $data['packages'] = Package::all();
        return view('website.pricing', $data);
    }



    public function blogs($slug = '') {
        $data = [];
        if ($slug) {
            $data['post'] = Post::where('slug', $slug)->first();
            if (! $data['post']) {
                abort(404);
            }
            return view('website.single-blog', $data);
        }
        $data['pageData']   = json_decode(get_trans_option('blogs_page'));
        $data['pageMedia']  = json_decode(get_trans_option('blogs_page_media'));
        $data['blog_posts'] = Post::active()->orderBy('id', 'desc')->paginate(12);
        $data['page_title'] = isset($data['pageData']->title) ? $data['pageData']->title : '';

        return view('website.blogs', $data);
    }

    public function faq() {
        $data               = [];
        $data['pageData']   = json_decode(get_trans_option('faq_page'));
        $data['page_title'] = isset($data['pageData']->title) ? $data['pageData']->title : '';

        $data['faqs'] = Faq::where('status', 1)->get();
        return view('website.faq', $data);
    }

    public function contact() {
        $data['pageData']   = json_decode(get_trans_option('contact_page'));
        $data['page_title'] = isset($data['pageData']->title) ? $data['pageData']->title : '';

        return view('website.contact', $data);
    }

    public function send_message(Request $request) {
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);

        Overrider::load("Settings");

        config(['recaptchav3.sitekey' => get_option('recaptcha_site_key')]);
        config(['recaptchav3.secret' => get_option('recaptcha_secret_key')]);

        $this->validate($request, [
            'name'                 => 'required',
            'email'                => 'required|email',
            'subject'              => 'required',
            'message'              => 'required',
            'g-recaptcha-response' => get_option('enable_recaptcha', 0) == 1 ? 'required|recaptchav3:register,0.5' : '',
        ]);

        //Send Email
        $name    = $request->input("name");
        $email   = $request->input("email");
        $subject = $request->input("subject");
        $message = $request->input("message");

        $mail          = new ContactMessage();
        $mail->name    = $name;
        $mail->email   = $email;
        $mail->subject = $subject;
        $mail->message = $message;
        $mail->save();

        if (get_option('email') != '') {
            try {
                Mail::to(get_option('email'))->send(new ContactUs($mail));
                return back()->with('success', _lang('Thank you for contacting us! We will respond to your message as soon as possible.'));
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage())->withInput();
            }
        }
    }

    /**
     * Store quotation from website form
     */
    public function storeQuotation(Request $request) {
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);

        $this->validate($request, [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'quotation_number' => 'nullable|string|max:100',
            'po_so_number' => 'nullable|string|max:100',
            'quotation_date' => 'required|date',
            'expired_date' => 'required|date|after:quotation_date',
            'project_description' => 'nullable|string',
            'template' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'footer' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Create or find customer
            $customer = \App\Models\Customer::where('email', $request->customer_email)->first();
            
            if (!$customer) {
                // Get default business for website quotations
                $defaultBusiness = \App\Models\Business::first();
                if (!$defaultBusiness) {
                    // Create a default business if none exists
                    $defaultBusiness = new \App\Models\Business();
                    $defaultBusiness->name = 'Default Business';
                    $defaultBusiness->user_id = 1; // Default user
                    $defaultBusiness->status = 1;
                    $defaultBusiness->save();
                }
                
                $customer = new \App\Models\Customer();
                $customer->user_id = 1; // Default user
                $customer->business_id = $defaultBusiness->id;
                $customer->name = $request->customer_name;
                $customer->email = $request->customer_email;
                $customer->mobile = $request->customer_phone;
                $customer->address = $request->customer_address;
                $customer->company_name = $request->company_name;
                $customer->currency = 'USD'; // Default currency
                $customer->save();
            }

            // Calculate totals with individual tax rates
            $subtotal = 0;
            $totalTax = 0;
            foreach ($request->items as $item) {
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemTax = $itemSubtotal * (($item['tax'] ?? 0) / 100);
                $subtotal += $itemSubtotal;
                $totalTax += $itemTax;
            }
            $grandTotal = $subtotal + $totalTax;

            // Create quotation
            $quotation = new \App\Models\Quotation();
            $quotation->customer_id = $customer->id;
            $quotation->business_id = $customer->business_id;
            $quotation->user_id = 1; // Default user
            $quotation->title = $request->title;
            $quotation->quotation_number = $request->quotation_number ?: 'QT-' . date('Y') . '-' . str_pad(\App\Models\Quotation::count() + 1, 4, '0', STR_PAD_LEFT);
            $quotation->po_so_number = $request->po_so_number;
            $quotation->quotation_date = $request->quotation_date;
            $quotation->expired_date = $request->expired_date;
            $quotation->sub_total = $subtotal;
            $quotation->grand_total = $grandTotal;
            $quotation->discount = 0;
            $quotation->discount_type = 1; // Fixed
            $quotation->discount_value = 0;
            $quotation->template_type = 1;
            $quotation->template = $request->template ?: 'default';
            $quotation->note = $request->notes;
            $quotation->footer = $request->footer;
            $quotation->save();

            // Add quotation items
            foreach ($request->items as $item) {
                // Get or create a default product
                $product = \App\Models\Product::first();
                if (!$product) {
                    $product = new \App\Models\Product();
                    $product->name = 'Default Product';
                    $product->type = 'sell';
                    $product->user_id = 1;
                    $product->business_id = $customer->business_id;
                    $product->save();
                }
                
                $quotationItem = new \App\Models\QuotationItem();
                $quotationItem->quotation_id = $quotation->id;
                $quotationItem->product_id = $product->id;
                $quotationItem->product_name = $item['name'];
                $quotationItem->description = '';
                $quotationItem->quantity = $item['quantity'];
                $quotationItem->unit_cost = $item['unit_price'];
                $quotationItem->sub_total = $item['quantity'] * $item['unit_price'];
                $quotationItem->user_id = 1; // Default user
                $quotationItem->business_id = $customer->business_id;
                $quotationItem->save();
            }

            DB::commit();

            // Generate PDF
            $pdf = \PDF::loadView('documents.quotation.default', compact('quotation'));
            $filename = 'quotation_' . $quotation->quotation_number . '.pdf';
            $pdfPath = storage_path('app/public/quotations/' . $filename);
            
            // Ensure directory exists
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0755, true);
            }
            
            $pdf->save($pdfPath);

            return response()->json([
                'success' => true,
                'message' => 'Quotation generated successfully! You can download it now.',
                'download_url' => asset('storage/quotations/' . $filename),
                'quotation_id' => $quotation->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error generating quotation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function post_comment(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email',
            'comment' => 'required',
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $post = Post::find($request->post_id);
        if (! $post) {
            return back()->with('error', 'Post not found')->withInput();
        }

        if (auth()->check()) {
            $request->merge(['user_id' => auth()->id()]);
            $request->merge(['name' => auth()->user()->name]);
            $request->merge(['email' => auth()->user()->email]);
        }
        $request->merge(['status' => 1]);
        $post->comments()->create($request->all());

        return back()->with('success', _lang('Your comment posted sucessfully.'));

    }

    public function email_subscription(Request $request) {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|email|unique:email_subscribers',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        $emailSubscriber                = new EmailSubscriber();
        $emailSubscriber->email_address = $request->email_address;
        $emailSubscriber->ip_address    = $request->ip();
        $emailSubscriber->save();

        if ($request->ajax()) {
            return response()->json(['result' => 'success', 'message' => _lang('Thank you for subscription')]);
        } else {
            return back()->with('success', _lang('Thank you for subscription'));
        }

    }

}