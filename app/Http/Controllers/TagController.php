<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'tag_name' => 'required|max:20|min:2'
        ]);


        Tag::create([
            'name' => $data['tag_name']
        ]);

        return back();
    }
}
