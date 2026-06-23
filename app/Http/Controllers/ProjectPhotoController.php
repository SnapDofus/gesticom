<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhoto;
use App\Http\Requests\StoreProjectPhotoRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectPhotoController extends Controller
{
    public function index()
    {
        $photos = ProjectPhoto::with('task')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $tasks = Task::where('user_id', Auth::id())->get();

        return view('photos.index', compact('photos', 'tasks'));
    }

    public function store(StoreProjectPhotoRequest $request)
    {
        $comment = $request->input('comment');
        $taskId = $request->input('task_id');

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('photos', 'public');

            ProjectPhoto::create([
                'filename' => $photo->hashName(),
                'original_name' => $photo->getClientOriginalName(),
                'path' => $path,
                'comment' => $comment,
                'task_id' => $taskId,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('photos.index')->with('success', 'Photos ajoutées avec succès.');
    }

    public function destroy(ProjectPhoto $photo)
    {
        $this->authorize('delete', $photo);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Photo supprimée avec succès.');
    }
}
