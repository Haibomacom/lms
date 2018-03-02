<?php

namespace App\Api\V1\Controllers\Book;

use App\Api\V1\Controllers\Controller;
use App\Models\BookFavorite;
use App\Transformers\FavoriteTransformer;
use Dingo\Api\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class FavoriteController extends Controller
{
    protected $favorite;

    public function __construct(BookFavorite $favorite)
    {
        $this->favorite = $favorite;
    }

    public function getList(Request $request)
    {
        $user = JWTAuth::authenticate($request->input('token'));

        return $this->response()->collection(
            $this->favorite->where('user_id', $user->id)->get(), new FavoriteTransformer()
        );
    }

    public function control(Request $request)
    {
        $user = JWTAuth::authenticate($request->input('token'));

        if (!$this->isExist($user->id, $request->input('id'))) {
            $this->favorite->insert([
                'user_id' => $user->id,
                'book_id' => $request->input('id'),
            ]);
        } else {
            $this->favorite
                ->where('user_id', $user->id)
                ->where('book_id', $request->input('id'))
                ->delete();
        }

        return $this->response()->noContent();
    }

    public function check(Request $request)
    {
        $user = JWTAuth::authenticate($request->input('token'));

        $isExist = $this->isExist($user->id, $request->input('id')) ? 1 : 0;

        $this->response()->error('0' . $isExist, 200);
    }

    public function isExist($user_id, $book_id)
    {
        return $this->favorite->where('user_id', $user_id)->where('book_id', $book_id)->first();
    }
}
