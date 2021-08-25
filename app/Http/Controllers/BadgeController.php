<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\BadgeImport;
use App\Models\Badge;
use App\Models\MetaAnswer;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class BadgeController extends Controller
{
    public function index()
    {
        $latest = [];
        $latestDate = Badge::max('created_at');
        if ($latestDate) {
            $latest = Badge::latest()->where('created_at', $latestDate)->get();
        }

        return Inertia::render('Badge/Index', [
            'count' => Badge::count(),
            'latest' => $latest,
            'uploadUrl' => URL::route('badge.upload'),
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,txt', 'max:2048'],
        ]);

        Excel::import(new BadgeImport, $request->file('file'));

        return Redirect::route('badge.index');
    }

    public function check($uuid)
    {
        $badge = Badge::where('uuid', $uuid)->orWhere('hex', $uuid)->first();
        if (!$badge) {
            return response()->json([
                'success' => true,
                'data' => [
                    "uuid" => null,
                    "hex" => null,
                    "hole" => null,
                ],
            ], Response::HTTP_OK);
        }

        $hole = $badge->hole;
        $answers = [];
        if ($hole) {
            $holeAnswers = MetaAnswer::where('hole_id', $hole->id)->orderBy('order')->get();
            foreach ($holeAnswers as $item) {
                $answers[] = [
                    'pageId' => $item->page_id,
                    'itemId' => $item->item_id,
                    'value' => $item->value,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                "uuid" => $badge->uuid,
                "hex" => $badge->hex,
                "hole" => $hole,
                "answers" => $answers,
            ],
        ], Response::HTTP_OK);
    }
}
