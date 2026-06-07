<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\Faq;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dynamicPageforWeb($slug)
    {
        $dynamicPage = DynamicPage::select(['page_title', 'page_content'])->where('status', 'active')->where('page_slug', $slug)->first();

        if (! $dynamicPage) {
            return view('errors.404')->with('error', 'Page not found');
        }


        return view('frontend.layouts.pages.singleDynamicPage', compact('dynamicPage'));
    }
}
