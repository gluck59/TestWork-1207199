<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{
    /**
     * return all records
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $items = Item::all();
        return view('list')->with('items', $items);
    }

    /**
     * create record
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $item = new Item;
        $item->item = $request->text;
        $item->save();
        return 'created';
    }

    /**
     * delete record
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
       // Item::where('id',$request->id)->delete();
        //return $request->all();
        $item = Item::find($request->id);
        $item->delete();
        return "deleted";
    }

    /**
     * update a record
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $item = Item::find($request->id);
        $item->item = $request->value;
        $item->save();
        return $request->all();
    }
}
