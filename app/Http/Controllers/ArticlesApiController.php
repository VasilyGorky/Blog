<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticlesApiController extends Controller
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

        return Validator::make($input, [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'text' => 'required|string'
        ]);
    }

    /**
     * Display a listing of the resource.
     * Метод возвращает все модели статей отсортированные
     * по полю created_at по убыванию с пагинацией в json формате
     * Если статей нет, то возвращается json с кодом 404.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $articles = $this->article->orderByRaw('created_at desc')->paginate(10);
        if ($articles) {
            return response()->json($articles, 200);
        }
        return response()->json('Not Found Articles', 404);
    }

    /**
     * Store a newly created resource in storage.
     * Метод добавления статьи в базу данных с валидацией полей
     * Если валидация не пройдена, то возвращается json с кодом 404.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $validator = $this->validateFieldsArticle();

        if ($validator->fails()) {
            return response()->json('Not Validation', 400);
        }

        $this->article->create([
            'title' => $this->request->input('title'),
            'text' => $this->request->input('text'),
            'description' => $this->request->input('description'),
        ]);

        return response()->json('Article was created', 201);
    }

    /**
     * Display the specified resource.
     * Метод возвращает модель статьи в json формате
     * Если статьи нет, то возвращается json с кодом 404
     * Если id не числовое значение, то возвращается json c кодом 400.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json('Not Validation', 400);
        }
        $article = $this->article->find($id);
        if ($article) {
            return response()->json($article, 206);
        }
        return response()->json('Not Found Article', 404);
    }

    /**
     * Remove the specified resource from storage.
     * Метод удаляет модель статьи и возвращает json с кодом 204
     * Если статьи нет, то возвращается json с кодом 404
     * Если id не числовое значение, то возвращается json c кодом 400.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json('Not Validation', 400);
        }
        $article = $this->article->find($id);
        if ($article) {
            $article->delete();
            return response()->json('Article was deleted', 204);
        }
        return response()->json('Not Found article', 404);
    }

    /**
     * Update the specified resource in storage.
     * Метод редактирования модели статьи выбранной из базы данных по $id,
     * возвращает json с кодом 200,
     * Если валидация не пройдена, то возвращается json с кодом 404.
     * Если id не числовое значение, то возвращается json c кодом 400.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        if (!is_numeric($id)) {
            return response()->json('Not Validation', 400);
        }
        $validator = $this->validateFieldsArticle();

        if ($validator->fails()) {
            return response()->json('Not Validation', 400);
        }

        $this->article->where('id', $id)->update
        ([
            'title' => $this->request->input('title'),
            'description' => $this->request->input('description'),
            'text' => $this->request->input('text')
        ]);
        return response()->json('Article was updated', 200);
    }
}