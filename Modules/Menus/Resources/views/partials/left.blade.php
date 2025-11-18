@if(!empty(request()->get('menu')))
<div id="accordion-left">

    @php
        $_module = Savefunction::request_module_defined('Post');
        if($_module){

        $pages = \Modules\Post\Http\Models\Page::where('status', 1)->get()->map(function ($page){
             return [
                 'url' => $page->slug,
                 'icon' => '',
                 'reference_id' => $page->id,
                 'reference_type' => \Modules\Post\Http\Models\Page::class,
                 'label' => $page->name,
             ];
        });
    @endphp
    @include('menus::accordions.default', [
        'name' => 'pages',
        'urls' => $pages,
        'show' => true
    ])
    @php
    $categories =  \Modules\Post\Http\Models\Category::where('status', 1)->get()->map(function ($categories){
             return [
                 'url' => $categories->slug,
                 'icon' => '',
                 'reference_id' => $categories->id,
                 'reference_type' => \Modules\Post\Http\Models\Category::class,
                 'label' => $categories->name,
             ];
        });
    @endphp
    @include('menus::accordions.default', ['name' => 'categories', 'urls' => $categories])

    @php
        }
        $_module_Branch = Savefunction::request_module_defined('Branch');
        if($_module_Branch){
    @endphp
    @php
    $branches =  \Modules\Branch\Http\Models\Branch::where('status', 1)->get()->map(function ($branches){
             return [
                 'url' => $branches->slug,
                 'icon' => '',
                 'reference_id' => $branches->id,
                 'reference_type' => \Modules\Branch\Http\Models\Branch::class,
                 'label' => $branches->name,
             ];
        });
    @endphp
    @include('menus::accordions.default', ['name' => 'branches', 'urls' => $branches])

    @php
        }
    @endphp
    @include('menus::accordions.add-link', ['name' => 'add_link'])
</div>
@endif
