<?php

namespace App\Http\Controllers\Web\Backend\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ContactSubmission::latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('message', fn($row) => strlen($row->message) > 40 ? substr($row->message, 0, 40) . '...' : $row->message)
                ->addColumn('status', fn($row) => '<span class="badge bg-' . ($row->is_read ? 'success' : 'warning') . '">' . ($row->is_read ? 'Read' : 'Unread') . '</span>')
                ->addColumn('action', function ($row) {
                    $showUrl = route('admin.contacts.show', $row->id);
                    $markRead = "markRead($row->id)";
                    $delete = "showDeleteConfirm($row->id)";

                    return "
                        <div class='text-center'>
                            <div class='btn-group btn-group-sm' role='group'>
                                <a href='$showUrl' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>
                                <a onclick='$markRead' class='btn btn-success btn-sm'><i class='fas fa-check'></i></a>
                                <a onclick='$delete' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                            </div>
                        </div>
                    ";
                })
                ->rawColumns([ 'message', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layouts.contact.index');
    }

    public function show(ContactSubmission $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('backend.layouts.contact.show', compact('contact'));
    }

    public function update(Request $request, ContactSubmission $contact)
    {
        if ($contact->is_read) {
            return response()->json(['status' => 'error', 'message' => 'Already marked as read']);
        }

        $contact->update(['is_read' => true]);
        return response()->json(['status' => 'success', 'message' => 'Marked as read']);
    }

    public function destroy(ContactSubmission $contact)
    {
        $contact->delete();
        return response()->json(['status' => 'success', 'message' => 'Contact submission deleted successfully']);
    }
}
