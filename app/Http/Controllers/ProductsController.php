<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    protected $redirectTo = '/products';
    private $user;

    public function index() {

        $this->user = Auth::user();
        $orderBy = 'id';
        $direction = 'desc';

        if ($this->user !== null) {
            $this->user = true;
        }

        $page = (int)Input::get('page');

        if ($page == null) {
            $page = 1;
        }

        $rowsNum = count(DB::table('products')->select('id')->get());
        $pages = round($rowsNum / 2);

        if (Input::get('filter') == 'lth') {
            $orderBy = 'price';
            $direction = 'asc';
        }

        if (Input::get('filter') == 'htl') {
            $orderBy = 'price';
            $direction = 'desc';
        }

        if (Input::get('filter') == 'a-z') {
            $orderBy = 'title';
            $direction = 'asc';
        }

        if (Input::get('filter') == 'z-a') {
            $orderBy = 'title';
            $direction = 'desc';
        }

        $data = DB::table('products')->orderBy($orderBy, $direction)->skip(($page - 1) * 2)->take($page * 2)->get();

        return view('products', [
            'data' => $data,
            'auth' => $this->user,
            'pages' => $pages
        ]);

    }

    public function create() {

        $this->user = Auth::user();

        if ($this->user == null) {
            return Redirect::to(URL::previous());
        }

        return view('createProduct', [
            'method' => 'POST',
            'url' => '/products',
            'btn' => 'Add product'
        ]);

    }

    public function store() {

        $this->user = Auth::user();

        if ($this->user == null) {
            return Redirect::to(URL::previous());
        }

        $data = Input::all();

        $image = addslashes($data['image']->getRealPath());
        $image = file_get_contents($image);

        $is_valid = Validator::make($data, [
            'title' => 'required|max:255',
            'desc' => 'required|max:15000',
            'price' => 'required',
            'image' => 'required',
        ]);

        if ($is_valid->fails()) {
            return Redirect::to('/products/create')->withErrors($is_valid);
        }

        if ((float)$data['price'] == 0) {
            return Redirect::to('/products/create')->withErrors(['priceError'=>'The price is not correct!']);
        }

        $save = DB::insert('INSERT INTO `products` (`title`, `description`, `price`, `image`) VALUES (?,?,?,?)', [
            $data['title'],
            $data['desc'],
            (float)$data['price'],
            $image
        ]);

        if ($save === false) {
            return Redirect::to('/products/create')->withErrors($is_valid);
        }

        return Redirect::to(URL::previous());

    }

    public function show($id) {

        $product = DB::table('products')->where('id', $id)->get();
        $comments = DB::table('comments')->orderBy('comment_date', 'desc')->where('product_id', $id)->get();

        if (!$product || !$comments) {
            return Redirect::to(URL::previous());
        }

        return view('viewProduct', [
            'product' => $product,
            'comments' => $comments
        ]);
    }

    public function addComment($id) {

        $comment = Input::get('comment');

        if (!$comment) {
            return Redirect::to(URL::previous());
        }

        $rows = [
            'comment' => $comment,
            'comment_date' => date('Y-m-d H:i:s'),
            'user_email' => Auth::user()->email,
            'product_id' => $id
        ];

        DB::table('comments')->insert($rows);

        return Redirect::to(URL::previous());

    }

    public function deleteComment($id) {

        $comment_id = Input::get('comment_id');

        if (!$comment_id) {
            return Redirect::to(URL::previous());
        }

        DB::table('comments')->where('id', $comment_id)->delete();

        return Redirect::to(URL::previous());

    }

    public function edit($id) {

        $this->user = Auth::user();

        if ($this->user == null) {
            return Redirect::to(URL::previous());
        }

        $product = DB::table('products')->where('id', $id)->get();

        if (!$product) {
            return Redirect::to(URL::previous());
        }

        return view('createProduct', [
            'product' => $product[0],
            'method' => 'PUT',
            'url' => '/products/' . $id,
            'btn' => 'Edit product',
            'edit' => true
        ]);

    }

    public function update($id) {

        $this->user = Auth::user();

        if ($this->user == null) {
            return Redirect::to(URL::previous());
        }

        $data = Input::all();

        $is_valid = Validator::make($data, [
            'title' => 'max:255',
            'desc' => 'max:255'
        ]);

        if ($is_valid->fails()) {
            return Redirect::to(URL::previous())->withErrors($is_valid);
        }

        if ((float)$data['price'] == 0) {
            return Redirect::to(URL::previous())->withErrors(['priceError'=>'The price is not correct!']);
        }

        $rows = array(
            'title' => $data['title'],
            'description' => $data['desc'],
            'price' => (float)$data['price']
        );

        if (isset($data['image'])) {
            $image = addslashes($data['image']->getRealPath());
            $image = file_get_contents($image);
            $rows['image'] = $image;
        }

        $updateResponse = DB::table('products')->where('id', $id)->update($rows);

        if ($updateResponse === false) {
            return Redirect::to(URL::previous())->withErrors($is_valid);
        }

        return Redirect::to('/products');

    }

    public function destroy($id) {

        $this->user = Auth::user();

        if ($this->user == null) {
            return Redirect::to(URL::previous());
        }

        if (($id) == null) {
            return Redirect::to('/products');
        }

        DB::table('products')->where('id', $id)->delete();

        return Redirect::to(URL::previous());
    }

}
