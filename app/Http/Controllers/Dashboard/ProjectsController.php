<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Scopes\ExcludeZeroOrderingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:projects-list|projects-create|projects-edit|projects-delete', ['only' => ['index','show']]);
        $this->middleware('permission:projects-create', ['only' => ['create','store']]);
        $this->middleware('permission:projects-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:projects-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $projects = Project::all();
        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Projects"], ['name' => "Browse"]
        ];
        return view('admin.content.projects.index', ['breadcrumbs' => $breadcrumbs, 'projects' => $projects]);
    }

    public function create(Request $request)
    {

        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Projects"], ['name' => "Create"]
        ];
        return view('admin.content.projects.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Projects"], ['name' => "Edit"]
        ];
        $project = Project::find($id);
        return view('admin.content.projects.edit', ['breadcrumbs' => $breadcrumbs,  'project' => $project]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($request->has('ordering')){
            $item->ordering = $request->ordering;
        }
        $item->setTranslation('title', $lang, $request->title)
            ->setTranslation('description', $lang, $request->description)
            ->save();

        if ($request->has('gallery')) {
            $images = $request->file('gallery');
            foreach ($images as $index => $image) {
                if ($image) {
                    $item->addMedia($image)->toMediaCollection('gallery');
                }
            }
        }
        return $item;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $lang = $request->lang;
            if ($lang === 'en') {
                $project = new Project();
                $this->translate($request, $request->lang, $project);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/projects')->with('success', 'Project added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $project = Project::withoutGlobalScope(ExcludeZeroOrderingScope::class)->find($id);
            $this->translate($request, $request->lang, $project);
            DB::commit();
            if($project->ordering === 0){
                return redirect('admin/projects/gallery')->with('success', 'Projects Gallery updated successfully');
            }
            return redirect('admin/projects')->with('success', 'Project updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $media = Media::findOrFail($id);
            $media->delete();
            DB::commit();
            return response()->json(['code' => 200,
                'message' => 'Image deleted successfully']
            );
        } catch (\Exception $exception) {
            return $exception;
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Project::findOrFail($id);
            $item->clearMediaCollection('images');
            $item->clearMediaCollection('mobile_image');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }

    public function saveGallery(Request $request){
        $page = Page::where('key', 'projects-page')->first();
        if ($request->has('gallery')) {
            $images = $request->file('gallery');
            foreach ($images as $index => $image) {
                if ($image) {
                    $page->addMedia($image)->toMediaCollection('gallery');
                }
            }
        }
        return redirect()->back()->with('success', 'Gallery added successfully');

    }

    public function gallery(Request $request){
        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Projects"], ['name' => "Gallery"]
        ];
        $page = Page::where('key', 'projects-page')->first();
        return view('admin.content.projects.gallery', ['breadcrumbs' => $breadcrumbs,  'page' => $page]);
    }
}
