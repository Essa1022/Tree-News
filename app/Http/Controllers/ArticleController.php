<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Article index
    public function index(Request $request, $category = null)
    {
            $articles = new Article();
            
            if($category)
            {
                $articles = $category->articles->where('status', true);
            }
            else
            {
                $articles = $articles->where('status', true);
            }

            if($request->most_view)
            {
                $articles = $articles->select(['id','title'])
                ->orderBy('views', 'desc');
            }
            elseif($request->most_comments)
            {
                $articles = $articles->select(['id','title'])
                ->withCount('comments')
                ->orderBy('comments_count', 'desc');
            }
            elseif($request->label)
            {
                $articles = $articles->whereHas('labels', function(Builder $querry)use($request)
                {
                    $querry->where('name', $request->label);
                });
            }
            elseif($request->last)
            {
                $articles = $articles->select(['id','title'])
                ->orderBy('id', 'desc');
            }

            $articles = $articles->paginate(10);
            return $this->responseService->success_response($articles);
    }

    // Show specific Article
    public function show(Request $request, string $id)
    {
        $article = Article::find($id);
        $article->increment('views');
        return $this->responseService->success_response($article);
    }

    // Store a new Article
    public function store(CreateArticleRequest $request)
    {
        if($request->user()->can('create.article'))
        {
            $input = $request->except(['status', 'view']);
            $input['user_id'] = $request->user()->id;
            $article = Article::create($input);
            return $this->responseService->success_response($article);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Update Article
    public function update(UpdateArticleRequest $request, string $id)
    {
        $article = Article::find($id);

        if ($request->user()->can('update.article') || $request->user()->id == $article->user_id)
        {
                $input = $request->except(['view']);

                if (!$request->user()->hasRole(['Admin', 'Super_Admin']))
                {
                    unset($input['status']);
                }

                $article->update($input);
                return $this->responseService->success_response($article);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Destroy Article
    public function destroy(Request $request)
    {
        if($request->user()->can('delete.article'))
        {
            $article_ids = $request->input('article_ids');
            Article::destroy($article_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}

