<?php

namespace App\Http\Controllers\PhoneBook;

use App\Http\Controllers\Controller;
use App\Http\Filters\PhoneBook\PhoneBookFilter;
use App\Http\Requests\PhoneBook\PhoneBookFilterRequest;
use App\Models\PhoneBook\PhoneBook;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    Auth,
    DB,
    Log
};

class PhoneBookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(PhoneBookFilterRequest $request)
    {
        $this->authorize('viewAny', PhoneBook::class);

        $data = $request->validated();

        if (isset($data['position'])) {
            $data['position'] = no_inject($data['position']);
        }

        if (isset($data['name'])) {
            $data['name'] = no_inject($data['name']);
        }

        if (isset($data['phone'])) {
            $data['phone'] = no_inject($data['phone']);
        }

        if (isset($data['email'])) {
            $data['email'] = no_inject($data['email']);
        }

        $filter = app()->make(PhoneBookFilter::class, ['queryParams' => array_filter($data)]);

        $users = User::filter($filter)
            ->orderBy('email')
            ->paginate(15);


        return view('phonebook.index', [
            'users' => $users,
            'old_filters' => $data,
        ]);
    }
}
