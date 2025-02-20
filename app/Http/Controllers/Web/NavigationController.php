<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Inquiry;
use App\Models\Page;
use App\Models\Slider;
use App\Models\Project;
use App\Models\Section;
use App\Models\Setting;
use App\Models\News;
use App\Models\QualityPolicy;
use App\Models\Statistic;
use App\Models\Service;
use App\Models\SurfaceTreatment;
use App\Models\Certificate;
use App\Models\ProductBySize;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Enums\CategoryEnum;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\RateLimiter;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Rules\ReCaptcha;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\App;

class NavigationController extends Controller
{
    public function mutual()
    {
        $data = [];
        $agent = new \Jenssegers\Agent\Agent;
        $data['is_mobile'] = $agent->isMobile();
        $data['header'] = [];
        $data['footer'] = [];
        $data['footer']['phone'] = Setting::where('key', 'phone')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['email'] = Setting::where('key', 'email')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['address'] = Setting::where('key', 'address')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['facebook'] = Setting::where('key', 'facebook')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['instagram'] = Setting::where('key', 'instagram')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['linkedin'] = Setting::where('key', 'linkedin')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['slogan'] = Setting::where('key', 'slogan')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['map'] = Setting::where('key', 'map')->first()->getTranslation('value', app()->getLocale());
        $data['footer']['iframe'] = Setting::where('key', 'iframe')->first()->getTranslation('value', app()->getLocale());
        $data['header']['brochure'] = Setting::where('key', 'brochure')->first()->getFirstMediaUrl('brochure');
        $brochure = Setting::where('key', 'brochure')->first()->getFirstMedia('brochure');
        $data['header']['brochure_name'] = $brochure ? $brochure->file_name : '';
        $data['header']['brochure_id'] = $brochure ? $brochure->id : '';
        $data['categories'] = Category::all();
        return $data;
    }

    public function home(Request $request)
    {
        $page = Page::where('key', 'home-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['sliders'] = Slider::active()->get();
        $data['sister_companies'] = Company::all();
        $data['news'] = News::whereNotNull('title->'.app()->getLocale())->orderBy('date', 'desc')->take(4)->get();
        $data['home_page_about'] = Section::where('key','home_page_about')->first();
        $data['home_page_visualizer'] = Section::where('key','home_page_visualizer')->first();

        /**General Data:End**/
        return view('web.home.index', compact('data'));
    }

    public function download_catalogue(Request $request, $id)
    {
        $category = Category::find($id);
        $catalogue = $category->getFirstMedia('catalogue');
        if($catalogue){
            $path = public_path('media/' . $catalogue->id . '/' . $catalogue->file_name);
            if (file_exists($path)) {
                return response()->download($path);
            }
        }
    }

    public function productsBySize(Request $request)
    {
        $page = Page::where('key', 'by-size-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['by_size_page_main'] = Section::where('key','by_size_page_main')->first();
        $data['products'] = ProductBySize::with('colors', 'colors.color')->get();
        // return $data['products'];
        return view('web.products.by-size', compact('data'));
    }

    public function products(Request $request, $slug)
    {
        $page = Category::where('slug', 'like', '%'.$slug.'%')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['page']->getFirstMediaUrl('cover');

        $locale = $request->locale ?? App::getLocale();
        if($page->id == CategoryEnum::InterlockingTiles->value){
            $filter = $request->filter ?? 'recent';
            $search = $request->search ?? '';
            $sort = 'created_at';
            $sortDir = 'DESC';
            $size = $request->size ?? '';
            
            if($request->filter){
                if($request->filter == 'a-z'){
                    $sort = 'title';
                    $sortDir = 'ASC';
                }elseif($request->filter == 'z-a'){
                    $sort = 'title';
                    $sortDir = 'DESC';
                }
            }

            $data['products'] = Product::where('category_id', $page->id)->when($search, function ($q) use ($search, $locale) {
                $q->Where("title", 'like', "%{$search}%");
            })
            ->orderBy($sort, $sortDir);

            if($size){
                $data['products'] = $data['products']->whereHas('sizes', function ($query) use ($size) {
                    $query->where('attribute_id', $size);
                });
            }

            if($request->filter || $request->search || $request->size || $request->page){
                $products = $data['products']->paginate(4);
                $products->getCollection()->transform(function ($product) use($locale) {
                    $product->title = $product->getTranslation('title', $locale);
                    return $product;
                });
                return response()->json([
                    'html' => view('web.products.partials.products', compact('products'))->render(),
                    'pagination' => view('web.products.partials.pagination', compact('products'))->render(),
                    'results' => view('web.products.partials.results', compact('products'))->render()
                ]);
            }
        }
        elseif($page->id == CategoryEnum::Kerbstone->value){
            $search = $request->search ?? '';
            $type = $request->type ?? 'all';

            $data['products'] = Product::where('category_id', $page->id)->when($search, function ($q) use ($search) {
                $q->Where('size', 'like', "%{$search}%")
                ->OrWhere('weight', 'like', "%{$search}%");
            });
            if($type != 'all'){
                $data['products'] = $data['products']->whereHas('types', function ($query) use ($type) {
                    $query->where('attribute_id', $type);
                });
            }
            if($request->search || $request->type || $request->page){
                $products = $data['products']->paginate(4)
                    ->appends([
                        'type' => $type,
                        'search' => $search
                    ]);
                return response()->json([
                    'html' => view('web.products.partials.kerb-products', compact('products', 'page'))->render(),
                    'pagination' => view('web.products.partials.pagination', compact('products'))->render(),
                    'results' => view('web.products.partials.results', compact('products'))->render()
                ]);
            }
        }else{
            $search = $request->search ?? '';

            $data['products'] = Product::where('category_id', $page->id)->when($search, function ($q) use ($search, $locale) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(description, '$.\"{$locale}\"')) LIKE ?", ["%{$search}%"]);
            });
            if($request->search || $request->page){
                $products = $data['products']->paginate(4);
                $products->getCollection()->transform(function ($product) use($locale) {
                    $product->description = $product->getTranslation('description', $locale);
                    return $product;
                });
                return response()->json([
                    'html' => view('web.products.partials.hollow-products', compact('products', 'page'))->render(),
                    'pagination' => view('web.products.partials.pagination', compact('products'))->render(),
                    'results' => view('web.products.partials.results', compact('products'))->render()
                ]);
            }
        }
        switch ($page->id) {
            case CategoryEnum::InterlockingTiles->value:
                $view = 'interlocking-list';
                $data['products'] = $data['products']->paginate(4);
                break;
            case CategoryEnum::Kerbstone->value:
                $view = 'kerbstones';
                $data['products'] = $data['products']->paginate(4);
                break;
            case CategoryEnum::CableCover->value:
                $view = 'cablecover';
                $data['products'] = $data['products']->get();
                break;
            case CategoryEnum::Hollow->value:
                $view = 'hollow';
                $data['products'] = $data['products']->paginate(4);
                break;
            case CategoryEnum::ConcreteSlabs->value:
                $view = 'hollow';
                $data['products'] = $data['products']->paginate(4);
                break;
            default:
                $view = 'interlocking-list';
                $data['products'] = $data['products']->paginate(4);
        }
        return view('web.products.'.$view, compact('data'));
    }

    public function productDetails(Request $request, $slug)
    {
        $page = Product::where('slug', 'like', '%'.$slug.'%')->first();
        if(!$page){
            throw new NotFoundHttpException;
        }
        $data = $this->mutual();
        $data['page'] = $page;
        $data['products'] = Product::where('id', '!=', $page->id)->where('category_id', $page->category_id)->get();
        $data['tailor_made_design'] = Section::where('key','tailor_made_design')->first();
        return view('web.products.interlocking-details', compact('data'));
    }

    public function download_product_file(Request $request, $file)
    {
        $product_file = Media::find($file);
        if($file){
            $path = public_path('media/' . $product_file->id . '/' . $product_file->file_name);
            if (file_exists($path)) {
                return response()->download($path);
            }
        }
    }

    public function aboutUs(Request $request)
    {
        $page = Page::where('key', 'about-us-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['statistics'] = Statistic::all();
        $data['policies'] = QualityPolicy::all();
        $data['certificates'] = Certificate::all();
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['about_page_main'] = Section::where('key','about_page_main')->first();
        $data['about_page_vision'] = Section::where('key','about_page_vision')->first();
        $data['about_page_mission'] = Section::where('key','about_page_mission')->first();
        /**General Data:End**/
        return view('web.about', compact('data'));
    }

    public function projects(Request $request)
    {
        $page = Page::where('key', 'projects-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['projects'] = Project::orderBy('ordering', 'asc')->get();
        $data['gallery'] = Media::where('model_type','App\Models\Page')->where('collection_name','gallery')->orderBy('id','asc')->get()->take(4);
        $data['hasMore'] = Media::where('model_type','App\Models\Page')->where('collection_name','gallery')->orderBy('id','asc')->get()->count() > 4;
        /**General Data:End**/
        return view('web.projects', compact('data'));
    }

    public function services(Request $request)
    {
        $page = Page::where('key', 'services-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['services'] = Service::orderBy('ordering', 'asc')->get();
        /**General Data:End**/
        return view('web.services', compact('data'));
    }

    public function treatments(Request $request)
    {
        $page = Page::where('key', 'surface-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['treatments'] = SurfaceTreatment::orderBy('ordering', 'asc')->get();
        /**General Data:End**/
        return view('web.treatments', compact('data'));
    }

    public function clients(Request $request)
    {
        $page = Page::where('key', 'clients-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['clients_trusted'] = Client::where('type', 'Trusted By')->get();
        $data['clients_contractors'] = Client::where('type', 'Contractors')->get();
        /**General Data:End**/
        return view('web.clients', compact('data'));
    }

    public function news(Request $request)
    {
        $page = Page::where('key', 'blogs-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['news'] = News::whereNotNull('title->'.app()->getLocale())->orderBy('date', 'desc')->paginate(12);

        /**General Data:End**/
        return view('web.news', compact('data'));
    }

    public function newsDetails(Request $request, $slug)
    {
        $blogs_page = Page::where('key', 'blogs-page')->first();
        $page = News::where('slug->'.app()->getLocale(), $slug)->first();
        if(!$page){
            $locale = app()->getLocale() === 'en' ? 'ar' : 'en';
            $page = News::where('slug->'.$locale, '=', $slug)->first();
            if($page->hasTranslation('slug', app()->getLocale())){
                return redirect()->to(url(app()->getLocale().'/blogs/'.$page->getTranslation('slug', app()->getLocale())));
            }
            return redirect(url(app()->getLocale().'/blogs'));
        }
        $data = $this->mutual();
        $data['page'] = $page;
        $data['blogs_page'] = $blogs_page;

        return view('web.news-details', compact('data'));
    }

    public function updateLastRead(Request $request)
    {
        $blog = News::find($request->blog_id);
        if ($blog) {
            $blog->last_read = now();
            $blog->save();

            return response()->json(['success' => true, 'message' => 'Last read updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Page not found.'], 404);
    }

    public function contactUs(Request $request)
    {
        $page = Page::where('key', 'contact-us-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['contact_page_get_contact'] = Section::where('key','contact_page_get_contact')->first();
        /**General Data:End**/
        return view('web.contact', compact('data'));
    }

    public function inquiry(Request $request)
    {
        $page = Page::where('key', 'inquiry-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['categories'] = Category::all();
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['inquiry_page_main'] = Section::where('key','inquiry_page_main')->first();
        /**General Data:End**/
        return view('web.inquiry', compact('data'));
    }

    public function tailorMade(Request $request)
    {
        $page = Page::where('key', 'tailormade-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $data['tailormade-page-main'] = Section::where('key','tailormade-page-main')->first();
        /**General Data:End**/
        return view('web.tailormade', compact('data'));
    }

    public function privacyPolicy(Request $request)
    {
        $page = Page::where('key', 'privacy-policy-page')->first();
        /**General Data:Start**/
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        /**General Data:End**/
        return view('web.template-page', compact('data'));
    }

    public function termsAndConditions(Request $request)
    {
        $page = Page::where('key', 'terms-and-conditions-page')->first();
        /**General Data:Start**/
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        /**General Data:End**/
        return view('web.template-page', compact('data'));
    }

    public function thankYou(Request $request)
    {
        $page = Page::where('key', 'thank-you-page')->first();
        /**General Data:Start**/
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        /**General Data:End**/
        return view('web.template-page', compact('data'));
    }

    public function submitForm(Request $request)
    {
        $key = 'submit-form-'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return redirect('/')
                ->withErrors(['error' => 'Too many submissions. Please try again later.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string|max:2000',
            'g-recaptcha-response' => ['required', new ReCaptcha],
            'honeypot' => 'nullable|string|size:0',
            'company' => 'required_if:type,inquiry|string|max:255',
            'category' => 'required_if:type,inquiry|string|max:255',
        ]);

        $pattern = '/(http|https|www\.)[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,}(\/\S*)?/';
        $nameHasUrl = preg_match($pattern, $request->name);
        $emailHasUrl = preg_match($pattern, $request->email);
        $phoneHasUrl = preg_match($pattern, $request->phone);
        $messageHasUrl = preg_match($pattern, $request->message);

        $emailPattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
        $messageHasEmail = preg_match($emailPattern, $request->message);

        if ($nameHasUrl || $emailHasUrl || $phoneHasUrl || $messageHasUrl || $messageHasEmail) {
            return redirect('/')
                ->withErrors(['error' => 'URLs are not allowed in the form fields.']);
        }

        $create = $request->except('g-recaptcha-response', 'honeypot');
        $create['name'] = e($request->name); // Escape special characters
        $create['email'] = e($request->email);
        $create['phone'] = e($request->phone);
        if ($request->has('message')) {
            $create['message'] = e($request->message);
        }

        Inquiry::create($create);

        RateLimiter::clear($key);

        return redirect(LaravelLocalization::localizeUrl('/thank-you'));
    }

    public function galleryLoadMore(Request $request)
    {
        $limit = 4;
        $offset = $request->input('offset');
        $gallery = Media::where('model_type','App\Models\Page')->where('collection_name','gallery')->orderBy('id','asc')->offset($offset)->limit($limit)->get();
        $hasMore = Media::where('model_type','App\Models\Page')->where('collection_name','gallery')->orderBy('id','asc')->get()->count() > $offset + $limit;
        $view = view('web.components.gallery', compact('gallery'))->render();
        return response()->json([
            'html' => $view,
            'hasMore' => $hasMore
        ]);
    }

    public function search(Request $request)
    {
        $page = Page::where('key', 'search-page')->first();
        $data = $this->mutual();
        $data['page'] = $page;
        $data['page']['header'] = $data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images');
        $query = $request->get('query');
        $data['search_categories'] = Category::where('title', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();
        $data['search_products'] = Product::where('title', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();

        return view('web.search', compact( 'data'));
    }
}
