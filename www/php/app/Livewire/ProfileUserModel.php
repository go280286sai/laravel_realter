<?php

namespace App\Livewire;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileUserModel extends Component
{
    use WithFileUploads;

    public ?object $user;
    #[Validate('required')]
    public string $name;
    #[Validate('required')]
    public ?string $birthday;
    #[Validate('required')]
    public ?string $phone;
    public ?int $gender_id = 0;
    public ?string $description = null;
    public string $password;
    public ?int $id;
    public $photo;


    public function save()
    {
        $this->validate();
        $obj = ['name' => $this->name, 'birthday' => $this->birthday, 'phone' => $this->phone,
            'gender_id' => $this->gender_id, 'description' => $this->description, 'password' => $this->password];
        $data = array_map(function ($value) {
            if ($value != "") {
                return $value;
            }
        }, $obj);
        User::edit($data, $this->id);
        session()->flash('status', 'Post successfully updated.');
    }

    public function logo()
    {
//        $this->validate([
//            'photo' => 'image|max:1024', // 1MB Max
//        ]);
//        $result = $this->photo->storeAs(path: 'public/img/profile', name: 'avatar');
//        $result = $this->photo->storePubliclyAs(path: 'photos', name: 'avatar', disk: 'public');
        // Можно здесь выполнить дополнительные действия с $path, например, сохранить в базу данных
//        User::updateProfilePhotoUser($this->photo->getPathName());
        if ($this->photo != null) {
            $this->photo->storeAs(path: 'profile', name: 'avatar');
        }
        session()->flash('message', 'Image uploaded successfully.');

        $this->reset('photo');
    }


    public function mount()
    {
        $this->id = Auth::user()->id;
        $this->user = User::find($this->id);
        $this->name = $this->user->name;
        $this->birthday = $this->user->birthday;
        $this->phone = $this->user->phone;
        $this->gender_id = $this->user->gender_id;
        $this->description = $this->user->description;

    }

    public function render()
    {
        return view('livewire.profile-user-model');
    }
}
