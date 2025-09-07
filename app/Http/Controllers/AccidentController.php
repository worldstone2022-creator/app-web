<?php

namespace App\Http\Controllers;


use App\Helper\Files;
use App\Helper\Reply;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use App\Jobs\ImportProductJob;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\DataTables\ProductsDataTable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Admin\Employee\ImportRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Admin\Employee\ImportProcessRequest;
use App\Traits\ImportExcel;

class AccidentController extends AccountBaseController
{
    use ImportExcel;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Accidents & Maladies';
        // $this->middleware(
        //     function ($request, $next) {
        //         in_array('client', user_roles()) ? abort_403(!(in_array('orders', $this->user->modules) && user()->permission('add_order') == 'all')) : abort_403(!in_array('products', $this->user->modules));

        //         return $next($request);
        //     }
        // );
    }

    /**
     * @param  ProductsDataTable $dataTable
     * @return mixed|void
     */
    public function index(ProductsDataTable $dataTable)
    {
        // $viewPermission = user()->permission('view_product');
        // abort_403(!in_array($viewPermission, ['all', 'added']));

        // $productDetails = [];
        // $productDetails = OrderCart::all();
        // $this->productDetails = $productDetails;

        // $this->totalProducts = Product::count();
        // $this->cartProductCount = OrderCart::where('client_id', user()->id)->count();

        // $this->categories = ProductCategory::all();
        // $this->subCategories = ProductSubCategory::all();
        // $this->unitTypes = UnitType::all();

        return $dataTable->render('accident.index', $this->data);
    }

   

}
