<?php

namespace Advert\Http\Controllers;

use Advert\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function create(Request $request)
    {
        Comment::create($request->except('_token'));
        return redirect()->route('view', $request->advert_id);
    }

    public function destroy($id,$advert_id)
    {
        Comment::destroy($id);
        return redirect()->route('view', $advert_id);
    }
}
