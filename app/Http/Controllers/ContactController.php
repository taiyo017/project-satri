<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function submit(Request $request)
    {
        // Validate
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'subject'   => 'nullable|string|max:255',
            'message'   => 'required|string|min:5',
        ]);

        // Store
        Contact::create($data);

        return back()->with('success', 'Thank you! Your message has been successfully sent.');
    }
    public function show(Contact $contact)
    {
        $contact->update(['is_read' => true]); // mark as read
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted.');
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Save reply to the database
        $reply = $contact->replies()->create([
            'message' => $request->message,
            'sender'  => 'admin'
        ]);

        // Send email to the user
        Mail::to($contact->email)
            ->send(new \App\Mail\ContactReplyMail(
                $contact->name,
                $reply->message
            ));

        return back()->with('success', 'Reply sent successfully!');
    }


    public function export()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
