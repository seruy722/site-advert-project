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

    public function create()
    {
        $rubrics = (new Advert)->getEnum('rubric');
        return view('create', ['rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);
    }

    public function add(Request $request)
    {
        // $this->validFields($request);
        $file = $this->saveUploadFile('image_names', $request);
        $arr = $request->except('_token');
        if ($file) {
            $arr['image_names'] = $file;
        }
        Advert::create($arr);
        return redirect()->route('accounts.user.home', $request->user_id);
    }

    public function view($id)
    {
        return view('view', ['advert' => Advert::where('id', $id)->first(), 'comments' => Comment::where('advert_id', $id)->get()]);
    }

    public function edit($id)
    {
        $rubrics = (new Advert)->getEnum('rubric');
        return view('edit', ['advert' => Advert::where('id', $id)->first(), 'rubrics' => explode(',', str_replace(['(', ')', 'enum', "'"], "", $rubrics))]);
    }

    public function update(Request $request)
    {
        $this->validFields($request);
        $file = $this->saveUploadFile('image_names', $request);
        $arr = $request->except('_token');
        if ($file) {
            $arr['image_names'] = $file;
        }
        Advert::where('id', $request->id)->update($arr);
        return redirect()->route('accounts.user.home', $request->user_id);
    }

    public function destroy($id, $userId, $role = null)
    {
        $advert = Advert::where('id', $id)->first();
        foreach (explode(',', $advert->image_names) as $img) {
            unlink(public_path() . '/images/' . $img);
        }
        Advert::destroy($id);
        Comment::where('advert_id', $id)->delete();
        if ($role == 'admin') {
            return redirect()->route('accounts.admin.home', $userId);
        } elseif ($role == 'user') {
            return redirect()->route('accounts.user.home', $userId);
        }
        return redirect()->route('index');
    }

    public function activate($id, $userId)
    {
        Advert::where('id', $id)->update(['active' => true]);
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
            'title' => 'required|min:2|string|max:255',
            'rubric' => 'required',
            'description' => 'required|min:20|max:1000',
            'image_names' => 'image|size:5120',
            'region' => 'required',
            'phone' => 'digits:10|unique:users,phone,' . $req->user_id,
        ], [
            'title.required' => 'Пожалуйста, укажите заголовок',
            'title.min' => 'Заголовок не может быть короче 2 знаков',
            'title.max' => 'Заголовок не может быть длиннее 255 знаков',
            'rubric.required' => 'Пожалуйста, выбирите рубрику из списка',
            'description.required' => 'Добавте описание обьявления',
            'description.min' => 'Описание не может быть короче 20 знаков',
            'description.max' => 'Описание не может быть длиннее 1000 знаков',
            'image_names.image' => 'Один из файлов не является изображением',
            'image_names.size' => 'Вы можете загрузить фотографий размером до 5 мб',
            'region.required' => 'Введите название города или населенного пункта',
            'phone.digits' => 'Телефон должен состоять из 10 цифр',
            'phone.unique' => 'Пользователь с таким телефоном уже существует',
        ]);
    }

}
