<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Create a new CategoryController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $pageSize = request()->get('pageSize', 10);
        $data = Category::query()->paginate($pageSize);

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $body = $request->all();

            $validation = Validator::make($body, [
                'name' => 'required|unique:categories|max:50',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Unprocessable Entity',
                    'errors' => $validation->errors(),
                ], 422);
            }

            $category = new Category();
            $category->fill($body);
            $category->save();

            return response()->json($category, 201);
        } catch (Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $category = Category::query()->findOrFail($id);
            return response()->json($category, 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $body = $request->all();

            $validation = Validator::make($body, [
                'name' => [
                    'required',
                    Rule::unique('categories')->ignore($id),
                ],
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Unprocessable Entity',
                    'errors' => $validation->errors(),
                ], 422);
            }

            $category = Category::query()->findOrFail($id);
            $category->fill($body);
            $category->update();

            return response()->json($category, 201);
        } catch (Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $category = Category::query()->findOrFail($id);
            $category->delete();

            return response()->json($category, 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 404);
        }
    }
}
