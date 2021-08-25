<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Hole;
use App\Models\HoleStatus;
use App\Models\MetaAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class HoleController extends Controller
{
    public function statuses()
    {
        $statues = HoleStatus::select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'data' => $statues,
        ], Response::HTTP_OK);
    }

    public function save(Request $request)
    {
        $request->validate([
            'holeId' => ['nullable', 'integer', 'exists:holes,id'],
            'badgeId' => ['required', 'string', 'min:7', 'max:7', 'exists:badges,hex'],
            'statusId' => ['required', 'integer', 'exists:hole_statuses,id'],
            'gridline' => ['required', 'string'],
            'observations' => ['required', 'string'],
            'holePhotos' => ['nullable', 'array'],
            'badgePhotos' => ['nullable', 'array'],
        ]);

        $badgeId = Badge::where('hex', $request->badgeId)->first()->id;
        $hole = null;
        $isUpdate = $request->has('holeId') && isset($request->holeId);
        if ($isUpdate) {
            $hole = Hole::where('id', $request->holeId)->first();

            if ($hole->badge_id != $badgeId) {
                return response()->json([
                    'success' => false,
                    'data' => 'The badge is not same what you used in create.',
                ], Response::HTTP_OK);
            }

            $hole->badge_id = $badgeId;
            $hole->status_id = $request->statusId;
            $hole->gridline = $request->gridline;
            $hole->observations = $request->observations;
            $hole->save();
        } else {
            $existing = Hole::where('badge_id', $badgeId)->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'data' => 'This badge is already in use.',
                ], Response::HTTP_OK);
            }

            $hole = Hole::create([
                'project_id' => 1,
                'badge_id' => $badgeId,
                'status_id' => $request->statusId,
                'gridline' => $request->gridline,
                'observations' => $request->observations,
            ]);
        }

        $middlePath = 'uploads/hole/' . $hole->id;

        // delete files
        $deletedPhotos = [];
        if ($request->has('deletedPhotos')) {
            $deletedPhotoJson = json_decode($request->deletedPhotos);
            foreach ($deletedPhotoJson->data as $path) {
                $deletedPhotos[] = $path;
                $filename = $path;
                if (Str::startsWith(Str::lower($path), 'http')) {
                    $filename = Str::replaceFirst(url('/') . '/' . $middlePath, public_path($middlePath), $path);
                }
                if (\File::exists($filename)) {
                    \File::delete($filename);
                }
            }
        }

        // hole photos
        $photos = [];
        if ($request->hasFile('holePhotos')) {
            foreach ($request->file('holePhotos') as $file) {
                if (Str::startsWith(Str::lower($file), 'http')) {
                    $photos[] = $file->name;
                } else {
                    $name = \Str::uuid() . '.' . $file->extension();
                    $file->move(public_path($middlePath), $name);
                    $photos[] = url('/') . '/' . $middlePath . '/' . $name;
                }
            }

            $photosUrl = $hole->hole_photos ? Arr::where($hole->hole_photos, function ($value, $key) use ($deletedPhotos) {
                return !in_array($value, $deletedPhotos);
            }) : [];

            $hole->hole_photos = array_merge($photos, $photosUrl);
            $hole->save();
        }

        // hole photos
        $photos = [];
        if ($request->hasFile('badgePhotos')) {
            foreach ($request->file('badgePhotos') as $file) {
                if (!Str::startsWith(Str::lower($file), 'http')) {
                    $name = \Str::uuid() . '.' . $file->extension();
                    $file->move(public_path($middlePath), $name);
                    $photos[] = url('/') . '/' . $middlePath . '/' . $name;
                }
            }

            $photosUrl = $hole->badge_photos ? Arr::where($hole->badge_photos, function ($value, $key) use ($deletedPhotos) {
                return !in_array($value, $deletedPhotos);
            }) : [];

            $hole->badge_photos = array_merge($photos, $photosUrl);
            $hole->save();
        }

        // answers
        if ($request->has('answers')) {
            $answersJson = json_decode($request->answers);
            $order = 1;
            MetaAnswer::where('hole_id', $hole->id)->forceDelete();
            foreach ($answersJson->data as $answer) {
                MetaAnswer::create([
                    'hole_id' => $hole->id,
                    'page_id' => $answer->pageId,
                    'item_id' => $answer->itemId,
                    'value' => $answer->value,
                    'order' => $order,
                ]);
                $order += 1;
            }
        }

        return response()->json([
            'success' => true,
            'data' => 'Added/Updated hole successfully.',
        ], Response::HTTP_OK);
    }

    public function replaceBadge(Request $request)
    {
        $request->validate([
            'holeId' => ['required', 'integer', 'exists:holes,id'],
            'oldBadge' => ['required', 'string', 'min:7', 'max:7', 'exists:badges,hex'],
            'newBadge' => ['required', 'string', 'min:7', 'max:7', 'exists:badges,hex'],
        ]);

        $oldBadgeId = Badge::where('hex', $request->oldBadge)->first()->id;
        $hole = Hole::where([
            'id' => $request->holeId,
            'badge_id' => $oldBadgeId,
        ])->first();

        if ($hole) {
            $newBadgeId = Badge::where('hex', $request->newBadge)->first()->id;
            $existing = Hole::where('badge_id', $newBadgeId)->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'data' => 'This badge is already in use.',
                ], Response::HTTP_OK);
            }

            $hole->badge_id = $newBadgeId;
            $hole->save();

            Badge::destroy('id', $oldBadgeId);
        }

        return response()->json([
            'success' => true,
            'data' => 'Replace badges successfully.',
        ], Response::HTTP_OK);
    }
}
