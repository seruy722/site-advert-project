<?php

namespace Advert\Http\Controllers;

use Advert\Advert;
use Advert\Comment;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AdvertsController extends Controller
{
    use ValidatesRequests;
    public function index(Request $request)
    {
        $rubrics = (new Advert)->getEnum('rubric');
        if ($request->isMethod('post')) {
            return view('index', ['all' => Advert::where('active', true)->where('title', 'LIKE', '%' . $request->search . '%')->paginate(15)]);
        }

        return view('index', ['all' => Advert::where('active', true)->orderBy('id', 'desc')->paginate(15), 'rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);
    }
    public function searchResult($search)
    {
        $rubrics = (new Advert)->getEnum('rubric');
        if ($search == 'asc' || $search == 'desc') {
            return view('search', ['all' => Advert::where('active', true)->orderBy('price', $search)->paginate(15), 'rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);
        }
        return view('search', ['all' => Advert::where('active', true)->where('rubric', $search)->orderBy('id', 'desc')->paginate(15), 'rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);

    }

    public function adminRubrics(Request $request)
    {
        $rubrics = (new Advert)->getEnum('rubric');
        $arr = explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics));
        if ($request->isMethod('post')) {
            $set = '';
            foreach ($request->rubrics as $item) {
                if ($item) {
                    $set .= "'" . str_replace("'", "''", $item) . "'" . ",";
                }
            }
            (new Advert)->changeEnum(rtrim($set, ','));
        }
        $rubrics = (new Advert)->getEnum('rubric');
        return view('accounts/admin/rubrics', ['rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics)), 'adverts' => Advert::where('active', true)->get()]);
    }

    public function createAdvert()
    {
        $rubrics = (new Advert)->getEnum('rubric');
        return view('create', ['rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);
    }

    public function addAdvert(Request $request)
    {
        $this->validFields($request);
        $file = $this->saveUploadFile('image_names', $request);
        $arr = $request->except('_token');
        if ($file) {
            $arr['image_names'] = $file;
        }
        Advert::create($arr);
        return redirect()->route('accounts.user.home', $request->user_id);
    }

    public function viewAdvert($id)
    {
        return view('view', ['advert' => Advert::findOrFail($id), 'comments' => json_decode(Advert::find($id)->comments->toJson())]);
    }

    public function editAdvert($id)
    {
        $rubrics = (new Advert)->getEnum('rubric');
        return view('edit', ['advert' => Advert::findOrFail($id), 'rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);
    }

    public function updateAdvert(Request $request)
    {
        $this->validFields($request, $request->id);
        $file = $this->saveUploadFile('image_names', $request);
        $arr = $request->except('_token');
        if ($file) {
            $arr['image_names'] = $file;
        }
        Advert::where('id', $request->id)->update($arr);
        return redirect()->route('accounts.user.home', $request->user_id);
    }

    public function destroyAdvert($id, $userId, $role = null)
    {
        $advert = Advert::findOrFail($id);
        foreach (explode(',', $advert->image_names) as $img) {
            if (!$img || $img == 'nofoto.jpg') {
                continue;
            }
            unlink(public_path() . '/images/' . $img);
        }
        Comment::where('advert_id', $id)->delete();
        Advert::destroy($id);
        if ($role == 'admin') {
            return redirect()->route('accounts.admin.home', $userId);
        } elseif ($role == 'user') {
            return redirect()->route('accounts.user.home', $userId);
        }
        return redirect()->route('index');
    }

    public function activateAdvert($id, $userId)
    {
        Advert::findOrFail($id)->update(['active' => true]);
        return redirect()->route('accounts.admin.home', $userId);
    }

    public function saveUploadFile($file, $req, $id = null)
    {
        if ($req->hasFile($file)) {
            $image = $req->file($file);
            $destinationPath = public_path('/images');
            $fileName = '';
            foreach ($image as $item) {
                $img = 'IMG-' . md5(microtime() . rand()) . '.' . $item->getClientOriginalExtension();
                $item->move($destinationPath, $img);
                $fileName .= ',' . $img;
            }
            return $fileName = ltrim($fileName, ',');
        } else {
            return false;
        }
    }

    public function validFields($req, $id = '')
    {
        $this->validate($req, [
            'title' => 'required|min:2|string|max:255|unique:adverts,title,' . $id,
            'rubric' => 'required|min:2|max:100',
            'description' => 'required|min:20|string|max:1000',
            'image_names.*' => 'mimes:jpg,jpeg,png|dimensions:max:5120',
            'region' => 'required|min:2|max:255',
            'price' => 'numeric',
            'phone' => 'digits:10',
        ]);
    }

}
