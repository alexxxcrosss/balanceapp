<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OperationResource;
use Illuminate\Http\Request;
use App\Models\User;

class MainController extends Controller
{
    private const OPERATIONS_PER_PAGE_DEFAULT = 5;

    public function __construct(private User $user)
    {
        $this->user = Auth::user();
    }

    /**
     * Главная страница
     *
     * @return void
     */
    public function index()
    {
        $data = $this->prepareData();
        return inertia('Index', $data);
    }

    /**
     * Данные на главной для обновления по ajax
     *
     * @return void
     */
    public function getData()
    {
        $data = $this->prepareData();
        return response()->json($data);
    }

    /**
     * Данные для главной страницы
     *
     * @return void
     */
    private function prepareData()
    {
        $operations = $this->user->getFilteredOperations(perPage: self::OPERATIONS_PER_PAGE_DEFAULT);
        $userResource = new UserResource($this->user);

        return [
            'user' => $userResource->resolve(),
            'operations' => OperationResource::collection($operations)->resolve(),
        ];
    }

    /**
     * Страница истории операций
     *
     * @param Request $request
     * @return void
     */
    public function history(Request $request)
    {
        $search = $request->input('search') ?? '';
        $sortOrder = $request->input('sortOrder') ?? 'desc';
        $operations = $this->user->getFilteredOperations($search, $sortOrder, self::OPERATIONS_PER_PAGE_DEFAULT);

        return inertia('History', [
            'operations' => OperationResource::collection($operations)->response()->getData(true),
            'filters' => [
                'search' => $search,
                'sortOrder' => $sortOrder,
            ],
        ]);
    }
}
