<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveRequestController extends Controller
{
    // Show Leave Request Page for Employees
    public function index()
    {
         $leaves = LeaveRequest::where('user_id', Auth::id())->paginate(3);
        return view('LeaveRequest', compact('leaves'));
    }

  // Store a Leave Request
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'start_date' => ['required', 'date', 'after_or_equal:today'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'reason' => ['required', 'string'],
                'document' => ['nullable', 'file', 'mimes:pdf,jpg,png,doc']
            ]);

            $filePath = null;
            if ($request->hasFile('document')) {
                $filePath = $request->file('document')->store('leave_documents', 'public');
            }

            LeaveRequest::create([
                'user_id' => Auth::id(),
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'reason' => $validatedData['reason'],
                'status' => 'Pending',
                'document' => $filePath,
            ]);

            return redirect()->back()->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit leave request. Please try again.');
        }
    }


   public function showPending()
    {
        $leaves = LeaveRequest::where('status', 'Pending')->with('user')->get();
        return view('ApproveRequest', compact('leaves'));
    }

    // Update leave request status (Approve/Reject)
    public function updateStatus(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = $request->status;
        $leave->save();

        return redirect()->route('ApproveRequest')->with('success', 'Leave status updated successfully.');
    }
}
