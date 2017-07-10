<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{
    
    public function index()
    {
        $items = Item::all();
        return view('list')->with('items', $items);
    }

    public function create(Request $request)
    {
        $item = new Item;
        $item->item = $request->text;
        $item->save();
        return 'created';
    }
    
    public function delete(Request $request)
    {
       // Item::where('id',$request->id)->delete();
        //return $request->all();
        $item = Item::find($request->id);
        $item->delete();
        return "deleted";
    }

    public function update(Request $request)
    {
        $item = Item::find($request->id);
        $item->item = $request->value;
        $item->save();
        return $request->all();
    }

    public function search(Request $request)
    {
        //$item = Item::find($request->id);
        //$item->item = $request->value;
        //$item->save();

        $term = $request->term;
        $items = Item::where('item', 'LIKE', '%'.$term.'%')->get();
        //return $item;
        if(count($items) == 0){
            $searchResult[] = 'No item found !';
        }else{
            foreach($items as $item){
                $searchResult[] = $item->item; 
            }
        }
        return $searchResult;

        /*return $availableTags = [
                    "ActionScript",
                    "AppleScript",
                    "Asp",
                    "BASIC",
                    "C",
                    "C++",
                    "Clojure",
                    "COBOL",
                    "ColdFusion",
                    "Erlang",
                    "Fortran",
                    "Groovy",
                    "Haskell",
                    "Java",
                    "JavaScript",
                    "Lisp",
                    "Perl",
                    "PHP",
                    "Python",
                    "Ruby",
                    "Scala",
                    "Scheme"
        ];*/
    }

}
