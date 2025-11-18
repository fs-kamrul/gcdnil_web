<?php

namespace Theme\SonaroyTheme\Http\Controllers;

use Modules\Ecommerce\Repositories\Interfaces\EcommerceFlashSaleInterface;
use Modules\Ecommerce\Repositories\Interfaces\EcommerceProductInterface;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Theme\Http\Controllers\PublicController;
use Theme\SonaroyTheme\Http\Resources\PostResource;
use Theme\SonaroyTheme\Http\Resources\ProductCategoryResource;
use Theme\SonaroyTheme\Http\Resources\BrandResource;
use Theme\SonaroyTheme\Http\Resources\ReviewResource;
use Theme;
use Cart;
use EcommerceHelper;

class SonaroyThemeController extends PublicController
{
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function ajaxCart(Request $request, DboardHttpResponse $response)
    {
        if (! $request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        return $response->setData([
            'count' => Cart::instance('cart')->count(),
            'html' => Theme::partial('cart-panel'),
        ]);
    }

    /**
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function getFeaturedProducts(Request $request, DboardHttpResponse $response)
    {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $data = [];

        $products = get_featured_products(array_merge([
            'take' => (int)$request->input('limit', 8),
            'with' => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
            ],
        ], EcommerceHelper::withReviewsParams()));

        foreach ($products as $product) {
            $data[] = view(
                Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item-small',
                compact('product')
            )->render();
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param PostInterface $postRepository
     * @return DboardHttpResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function ajaxGetPosts(Request $request, DboardHttpResponse $response, PostInterface $postRepository)
    {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $posts = $postRepository->getFeatured(4, ['slugable']);

        return $response
            ->setData(PostResource::collection($posts))
            ->toApiResponse();
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function getFeaturedProductCategories(Request $request, DboardHttpResponse $response)
    {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $categories = get_featured_product_categories(['take' => null]);

        return $response->setData(ProductCategoryResource::collection($categories));
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function ajaxGetFeaturedBrands(Request $request, DboardHttpResponse $response)
    {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $brands = get_featured_brands();

        return $response->setData(BrandResource::collection($brands));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param EcommerceProductInterface $productRepository
     * @return DboardHttpResponse
     */
    public function ajaxGetProductReviews(
        $id,
        Request $request,
        DboardHttpResponse $response,
        EcommerceProductInterface $productRepository
    ) {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $product = $productRepository->getFirstBy([
            'id' => $id,
            'status' => DboardStatus::PUBLISHED,
            'is_variation' => 0,
        ]);

        if (! $product) {
            abort(404);
        }

        $star = (int)$request->input('star');
        $perPage = (int)$request->input('per_page', 10);

        $reviews = EcommerceHelper::getProductReviews($product, $star, $perPage);

        if ($star) {
            $message = __(':total review(s) ":star star" for ":product"', [
                'total' => $reviews->total(),
                'product' => $product->name,
                'star' => $star,
            ]);
        } else {
            $message = __(':total review(s) for ":product"', [
                'total' => $reviews->total(),
                'product' => $product->name,
            ]);
        }

        return $response
            ->setData(ReviewResource::collection($reviews))
            ->setMessage($message)
            ->toApiResponse();
    }

    /**
     * @param int $id
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param EcommerceProductInterface $productRepository
     * @return DboardHttpResponse
     */
    public function ajaxGetRelatedProducts(
        $id,
        Request $request,
        DboardHttpResponse $response,
        EcommerceProductInterface $productRepository
    ) {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $product = $productRepository->findOrFail($id);

        $products = get_related_products($product, (int)$request->input('limit'));

        $data = [];
        foreach ($products as $product) {
            $data[] = view(
                Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item',
                compact('product')
            )->render();
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param EcommerceFlashSaleInterface $flashSaleRepository
     * @return DboardHttpResponse
     */
    public function ajaxGetFlashSales(
        Request $request,
        DboardHttpResponse $response,
        EcommerceFlashSaleInterface $flashSaleRepository
    ) {
        if (! $request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        $flashSales = $flashSaleRepository->getModel()
            ->notExpired()
            ->where('status', DboardStatus::PUBLISHED)
            ->with([
                'products' => function ($query) use ($request) {
                    $reviewParams = EcommerceHelper::withReviewsParams();

                    if (EcommerceHelper::isReviewEnabled()) {
                        $query->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
                    }

                    return $query
                        ->where('status', DboardStatus::PUBLISHED)
                        ->limit((int) $request->input('limit', 2))
                        ->withCount($reviewParams['withCount']);
                },
            ])
            ->get();

        if (! $flashSales->count()) {
            return $response->setData([]);
        }

        $data = [];
        foreach ($flashSales as $flashSale) {
            foreach ($flashSale->products as $product) {
                if (! EcommerceHelper::showOutOfStockProducts() && $product->isOutOfStock()) {
                    continue;
                }

                $data[] = Theme::partial('flash-sale-product', compact('product', 'flashSale'));
            }
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function ajaxGetProducts(Request $request, DboardHttpResponse $response)
    {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $products = get_products_by_collections(array_merge([
            'collections' => [
                'by' => 'id',
                'value_in' => [$request->input('collection_id')],
            ],
            'take' => 8,
            'with' => [
                'slugable',
                'variations',
                'productCollections',
                'variationAttributeSwatchesForProductList',
            ],
        ], EcommerceHelper::withReviewsParams()));

        $data = [];
        foreach ($products as $product) {
            $data[] = view(
                Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item',
                compact('product')
            )->render();
        }

        return $response->setData($data);
    }

    /**
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function ajaxGetProductsByCategoryId(
        Request $request,
        DboardHttpResponse $response,
        EcommerceProductInterface $productRepository
    ) {
        if (! $request->ajax() || ! $request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $categoryId = $request->input('category_id');

        if (! $categoryId) {
            return $response;
        }

        $products = $productRepository->getProductsByCategories(array_merge([
            'categories' => [
                'by' => 'id',
                'value_in' => [$categoryId],
            ],
            'take' => 8,
        ], EcommerceHelper::withReviewsParams()));

        $data = [];
        foreach ($products as $product) {
            $data[] = view(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
                ->render();
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param int $id
     * @param DboardHttpResponse $response
     * @return mixed
     */
    public function getQuickView(Request $request, $id, DboardHttpResponse $response)
    {
        if (! $request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        $product = get_products(array_merge([
            'condition' => [
                'ecommerce_products.id' => $id,
                'ecommerce_products.status' => DboardStatus::PUBLISHED,
            ],
            'take' => 1,
            'with' => [
                'slugable',
                'tags',
                'tags.slugable',
                'options' => function ($query) {
                    return $query->with('values');
                },
            ],
        ], EcommerceHelper::withReviewsParams()));

        if (! $product) {
            return $response->setNextUrl(route('public.index'));
        }

        list($productImages, $productVariation, $selectedAttrs) = EcommerceHelper::getProductVariationInfo($product);

        return $response->setData(Theme::partial('quick-view', compact('product', 'selectedAttrs', 'productImages')));
    }
}
