<?php

namespace Advert\Http\Controllers;

use Advert\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CommentsController extends Controller
{
    use ValidatesRequests;
    public function create(Request $request)
    {
        $this->validFields($request);
        Comment::create($request->except('_token'));
        return redirect()->route('view', $request->advert_id);
    }

    public function destroy($id,$advert_id)
    {
        Comment::destroy($id);
        return redirect()->route('view', $advert_id);
    }

    public function validFields($req, $id = '')
    {
        $this->validate($req, [
            'comment' => 'required|min:2|string|max:255',
        ]);
    }
}
