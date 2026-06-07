<?php
namespace App\Http\Controllers\Web\Backend\CMS;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\CmsContentRequest;
use App\Models\CmsContent;
use App\Services\CmsContentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CmsContentController extends Controller
{
    protected CmsContentService $cmsService;

    public function __construct(CmsContentService $cmsService)
    {
        $this->cmsService = $cmsService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CmsContent::latest()->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('page', fn($row) => ucfirst($row->page))
                ->addColumn('section', fn($row) => ucfirst(str_replace('_', ' ', $row->section)))
                ->addColumn('main_title', fn($row) => $row->main_title ?? $row->title ?? '—')
                ->addColumn('is_active', function ($row) {
                    $next    = $row->is_active ? 0 : 1;
                    $checked = $row->is_active ? 'checked' : '';
                    return '
                        <a href="#" class="change_cms_status"
                            data-id="' . $row->id . '"
                            data-enabled="' . $next . '"
                            data-title="Do you want to ' . ($next ? 'Enable' : 'Disable') . ' this CMS content?"
                            data-description="' . ($next ? 'This content will be visible.' : 'This content will be hidden.') . '"
                            data-bs-toggle="modal"
                            data-bs-target="#cmsStatusmodal">
                            <label class="switch">
                                <input type="checkbox" ' . $checked . '>
                                <span class="slider round"></span>
                            </label>
                        </a>';
                })

                ->addColumn('action', function (CmsContent $data) {
                    return view('components.action-buttons', [
                        'id'     => $data->id,
                        'show'   => 'admin.cms_contents.show',
                        'edit'   => 'admin.cms_contents.edit',
                        'delete' => true,
                    ])->render();
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('backend.layouts.cms.index');
    }

    public function create()
    {
        $pages         = Page::cases();
        $sections      = Section::cases();
        $sectionConfig = config('cms_sections');

        return view('backend.layouts.cms.create', compact('pages', 'sections', 'sectionConfig'));
    }

    public function store(CmsContentRequest $request)
    {
        $this->cmsService->store($request->validated());
        return redirect()->route('admin.cms_contents.index')->with('success', 'CMS Content created successfully.');
    }

    public function edit(CmsContent $cms_content)
    {
        $pages         = Page::cases();
        $sections      = Section::cases();
        $sectionConfig = config('cms_sections');

        $cms_content->load('items');

        $page    = $cms_content->page;
        $section = $cms_content->section;

        $sectionDef = $sectionConfig[$page][$section] ?? [];
        $fields     = $sectionDef['fields'] ?? [];
        $itemFields = $sectionDef['items'] ?? [];

        $content = [];
        foreach ($fields as $field) {
            $content[$field] = $cms_content->{$field} ?? null;
        }

        $cms_content->content     = $content;
        $cms_content->item_fields = $itemFields;

        return view('backend.layouts.cms.create', compact('pages', 'sections', 'sectionConfig', 'cms_content'));
    }

    public function update(CmsContentRequest $request, CmsContent $cms_content)
    {
        $this->cmsService->update($cms_content, $request->validated());
        return redirect()->route('admin.cms_contents.index')->with('success', 'CMS Content updated successfully.');
    }

    public function show(CmsContent $cms_content)
    {
        $cms_content->load('items');
        return view('backend.layouts.cms.show', compact('cms_content'));
    }

    public function status(Request $request, CmsContent $cms_content)
    {
        $request->validate(['is_active' => 'required|boolean']);
        $cms_content->update(['is_active' => (bool) $request->is_active]);

        return response()->json(['status' => 'success']);
    }

    public function destroy(CmsContent $cms_content)
    {
        $this->cmsService->destroy($cms_content);
        return response()->json(['status' => 'success']);
    }

    public function getSectionsByPage(Request $request)
    {
        $page          = $request->input('page');
        $sectionConfig = config('cms_sections');

        if (! isset($sectionConfig[$page])) {
            return response()->json([], 404);
        }

        $sections = array_keys($sectionConfig[$page]);
        return response()->json($sections);
    }
}
