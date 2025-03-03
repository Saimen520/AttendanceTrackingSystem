<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // Show the form to create an announcement
    public function create()
    {
        return view('Announcement');
    }

    // Store the announcement in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'document' => ['nullable', 'file', 'mimes:pdf,jpg,png,doc,docx', 'max:2048']
        ]);

        try {
            // Handle file upload
            $filePath = null;
            if ($request->hasFile('document')) {
                $filePath = $request->file('document')->store('announcements', 'public');
            }

            // Create announcement
            $announcement = Announcement::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'message' => $request->message,
                'document' => $filePath,
            ]);

            // Attach all users to the announcement
            $users = User::all();
            foreach ($users as $user) {
                $announcement->users()->attach($user->id, ['read' => false]);
            }

            return redirect()->route('Announcement')->with('success', 'Announcement posted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating announcement: ' . $e->getMessage());
        }
    }

    // Show all announcements
    public function index()
    {
        $announcements = Announcement::with('user')->latest()->paginate(3); // Show 3 announcements per page
        
         $announcements->onEachSide(1);
        
        // Process each announcement's message to make emails and URLs clickable
        $announcements->getCollection()->transform(function ($announcement) {
            $announcement->message = $this->makeClickableLinks($announcement->message);
            return $announcement;
        });

        return view('ViewAnnouncement', compact('announcements'));
    }

    // Helper function to make emails and URLs clickable
    private function makeClickableLinks($text)
    {
        // Convert URLs to clickable links
        $text = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', $text);

        // Convert email addresses to clickable links
        $text = preg_replace('!([\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})!i', '<a href="mailto:$1">$1</a>', $text);

        return $text;
    }
    
    
    public function markAsRead($id)
    {
        $user = Auth::user();
        $user->announcements()->updateExistingPivot($id, ['read' => true]);

        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->announcements()->updateExistingPivot($user->announcements->pluck('id'), ['read' => true]);
        }

        return response()->json(['success' => true]);
    }
    
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id); // Ensure it exists

        // Ensure only admins can delete
        if (auth()->user()->role->id !== 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }


}
