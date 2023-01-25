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
            $data['position'] = (string) Str::of($data['position'])->lower()->remove(config('stop-list'));
        }

        if (isset($data['name'])) {
            $data['name'] = (string) Str::of($data['name'])->lower()->remove(config('stop-list'));
        }

        if (isset($data['phone'])) {
            $data['phone'] = (string) Str::of($data['phone'])->lower()->remove(config('stop-list'));
        }

        if (isset($data['email'])) {
            $data['email'] = (string) Str::of($data['email'])->lower()->remove(config('stop-list'));
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
