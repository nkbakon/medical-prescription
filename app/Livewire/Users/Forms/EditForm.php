<?php

namespace App\Livewire\Users\Forms;

use Livewire\Component;
use App\Models\User;

class EditForm extends Component
{
    public $user;
    public $type;
    public $fname;
    public $lname;
    public $username;
    public $email;
    public $contact;
    public $dob;
    public $status;

    public function rules()
    {
        return [
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|unique:users,username,' . $this->user->id,
            'email' => 'required|unique:users,email,' . $this->user->id,
            'type' => 'required',
            'contact' => 'required|unique:users,contact,' . $this->user->id,
            'dob' => 'required',
            'status' => 'required',
        ];
    }

    public function mount($user)
    {
        $this->user = $user;
        $this->fname = $user->fname;
        $this->lname = $user->lname;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->type = $user->type;
        $this->contact = $user->contact;
        $this->dob = $user->dob;
        $this->status = $user->status;
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['fname'] = $this->fname;
        $data['lname'] = $this->lname;
        $data['username'] = $this->username;
        $data['email'] = $this->email;
        $data['type'] = $this->type;
        $data['contact'] = $this->contact;
        $data['dob'] = $this->dob;
        $data['status'] = $this->status;
        
        $this->user->update($data);        
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function render()
    {
        return view('users.components.edit-form');
    }
}

