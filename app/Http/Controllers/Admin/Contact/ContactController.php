<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%')
                ->orwhere('email', 'LIKE', '%' . request()->keyword . '%')
                ->orwhere('title', 'LIKE', '%' . request()->keyword . '%');
        })
            ->when(!is_null(request()->status), function ($query) {
                $query->where('status', request()->status);
            })

            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))->paginate(request('limit_by', 5));

        return view('Admin.contacts.index', compact('contacts'));
    }
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update([
            'status' => 1,
        ]);
        return view('Admin.contacts.show', compact('contact'));
    }
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted successfully');
    }
}
