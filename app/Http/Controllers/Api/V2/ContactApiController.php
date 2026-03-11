<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'email'   => 'required|email|max:255',
                'subject' => 'nullable|string|max:255',
                'message' => 'required|string|max:5000',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }

        $contact = Contact::create($validated);

        return response()->json([
            'success' => true,
            'result'  => [
                'data'    => $contact,
                'message' => "Xabaringiz muvaffaqiyatli yuborildi. Tez orada siz bilan bog'lanamiz.",
            ],
        ], 201);
    }
}
