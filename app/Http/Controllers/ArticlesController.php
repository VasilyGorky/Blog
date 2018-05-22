<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    private $article;
    private $request;

    /**
     * ArticlesController constructor.
     * @param Article $article
     * @param Request $request
     */
    public function __construct(Article $article, Request $request)
    {
        $this->article = $article;
        $this->request = $request;
    }

    /**
     * Метод валидации полей
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateFieldsArticle()
    {
        $input = $this->request->all();
        $massages =
            [
                'required' => 'Field :attribute is required',
                'max' => 'The maximum number of characters exceeded in the :attribute field'
            ];

        return Validator::make($input,
            [
                'title' => 'required|string|max:100',
                'description' => 'required|string|max:255',
                'text' => 'required|string'
            ], $massages);
    }

    /**
     * Display a listing of the resource.
     * Метод возвращает view home со всеми моделями статей отсортированные
     * по полю created_at по убыванию с пагинацией
     * Если view home не существует, то выбрасывается HttpException с кодом 404.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function index()
    {
        if (view()->exists('home')) {
            $articles = $this->article->orderByRaw('created_at desc')->paginate(10);
            return view('home', ['articles' => $articles]);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * Метод возвращает view для редактирования данных
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('addFormArticle');
    }

    /**
     * Store a newly created resource in storage.
     * Метод добавления статьи в базу данных с валидацией полей
     * делает redirect в route article.index, выбрасывается HttpException с кодом 404
     * если view addFormArticle не существует
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function store()
    {
        if (view()->exists('addFormArticle')) {
            if ($this->request->isMethod('post')) {
                $validator = $this->validateFieldsArticle();

                if ($validator->fails()) {
                    return redirect()->route('articles.create')->withErrors($validator)->withInput();
                }

                $this->article->create
                ([
                    'title' => $this->request->input('title'),
                    'text' => $this->request->input('text'),
                    'description' => $this->request->input('description'),
                ]);
                return redirect()->route('articles.index');
            }
        }
        abort(404);
    }

    /**
     * Display the specified resource.
     * Метод возращает view article с моделью статьи выбранной по $id
     * Если view article не существует, то выбрасывается HttpException с кодом 404.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function show($id)
    {
        if (view()->exists('article')) {
            $article = $this->article->find($id);
            return view('article', ['article' => $article]);
        }
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     * Метод удаляет модель статьи выбранной по $id
     * и делает перенаправление на route article.index
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = $this->article->find($id);
        $article->delete();
        return redirect()->route('articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     * $old получает старые данные выбранной по $id статьи, преобразованные в массив
     * и перенаправляет во view editFormArticle
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $old = $this->article->find($id)->toArray();
        $data = [
            'id' => $old['id'],
            'title' => $old['title'],
            'text' => $old['text'],
            'description' => $old['description']
        ];
        return view('editFormArticle', ['data' => $data]);
    }


    /**
     * Update the specified resource in storage.
     * Метод редактирования модели статьи выбранной из базы данных по $id с валидацией полей,
     * делает перенаправление в route article.show по $id,
     * Если view editFormArticle не существует, то выбрасывается HttpException с кодом 404.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function update($id)
    {
        if (view()->exists('editFormArticle')) {
            if ($this->request->isMethod('put')) {
                $input = $this->request->all();
                $validator = $this->validateFieldsArticle();

                if ($validator->fails()) {
                    return redirect()->route('articles.edit', $id)->withErrors($validator)->withInput();
                }

                $this->article->fill($input);
                $this->article->where('id', $id)->update
                ([
                    'title' => $input['title'],
                    'description' => $input['description'],
                    'text' => $input['text'],
                ]);
                return redirect()->route('articles.show', $id);
            }
        }
        abort(404);
    }
}
