<?php

namespace App\Http\Controllers;

use App\Models\MetaApp;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MetaController extends Controller
{
    public function fetch()
    {
        $user = Auth::user();
        $meta = MetaApp::where('role_id', $user->role->id)->orderBy('order')->get();

        $data = [];
        foreach ($meta as $item) {
            $page = $item->page;
            $data[] = [
                'id' => $page->id,
                'title' => $page->title,
                'question' => $page->question,
                'items' => $page->items->load('element'),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
