<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NoteController extends Controller
{
    public function index()
    {
        return view('note.index', [
            'title' => 'SCKKJ - Agenda',
            'titleHeader' => 'Agenda',
        ]);
    }

    public function list(Request $request)
    {
        $query = Note::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('due_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('due_date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'done':
                    $query->where('is_done', true);
                    break;
                case 'running':
                    $query->where('is_done', false)->whereNotNull('due_date')->where('due_date', '>', now()->addDay());
                    break;
                case 'warning':
                    $query->where('is_done', false)->whereBetween('due_date', [now(), now()->addDay()]);
                    break;
                case 'late':
                    $query->where('is_done', false)->where('due_date', '<', now());
                    break;
                case 'nodate':
                    $query->where('is_done', false)->whereNull('due_date');
                    break;
            }
        }

        $notes = $query->latest()->paginate(20);
        $notes->getCollection()->transform(function ($note) {
            $note->attachment_url = $note->attachment ? asset('storage/' . $note->attachment) : null;
            return $note;
        });

        return response()->json($notes);
    }

    public function toggle(Note $note)
    {
        abort_if($note->user_id != auth()->id(), 403);

        $note->update([
            'is_done' => !$note->is_done
        ]);

        return response()->json([
            'success' => true,
            'is_done' => $note->is_done
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable'],
            'due_date' => ['nullable', 'date'],
            'attachment' => ['nullable', 'image', 'max:512', 'mimes:jpg,jpeg,png,webp'], // 5 MB
        ],
        [
            'attachment.image' => 'Lampiran harus berupa gambar.',
            'attachment.max' => 'Ukuran lampiran maksimal 512 KB.',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $folder = 'notes/' . auth()->id();
            $validated['attachment'] = $request->file('attachment')->store($folder, 'public');
        }

        $note = Note::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil ditambahkan.',
            'data' => $note,
        ]);
    }

    public function update(Request $request, Note $note)
    {
        abort_if($note->user_id != auth()->id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable'],
            'due_date' => ['nullable', 'date'],
            'attachment' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {

            // Hapus gambar lama
            if ($note->attachment && Storage::disk('public')->exists($note->attachment)) {
                Storage::disk('public')->delete($note->attachment);
            }

            $folder = 'notes/' . auth()->id();
            $validated['attachment'] = $request->file('attachment')->store($folder, 'public');
        }

        $note->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil diperbarui.',
        ]);
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id != auth()->id(), 403);

        if ($note->attachment && Storage::disk('public')->exists($note->attachment)) {
            Storage::disk('public')->delete($note->attachment);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil dihapus.',
        ]);
    }
}