<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SaleCampaignController extends Controller
{
    private function validateItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function rule1(Request $request)
    {
        $validated = $this->validateItems($request);
        $items = $validated['items'];
        sort($items);
        $discounted = [];
        $payable = [];

        while (count($items) > 1) {
            $payable[] = array_pop($items);
            $discounted[] = array_pop($items);
        }
        if (count($items) === 1) {
            $payable[] = array_pop($items);
        }

        return response()->json([
            'discounted_items' => $discounted,
            'payable_items' => $payable
        ]);
    }

    public function rule2(Request $request)
    {
        $validated = $this->validateItems($request);
        $items = $validated['items'];
        sort($items);
        $discounted = [];
        $payable = [];

        while (count($items) > 1) {
            $payable[] = array_pop($items);
            if (end($items) < end($payable)) {
                $discounted[] = array_pop($items);
            }
        }
        if (count($items) === 1) {
            $payable[] = array_pop($items);
        }

        return response()->json([
            'discounted_items' => $discounted,
            'payable_items' => $payable
        ]);
    }

    public function rule3(Request $request)
    {
        $validated = $this->validateItems($request);
        $items = $validated['items'];
        sort($items);
        $discounted = [];
        $payable = [];

        while (count($items) > 3) {
            $payable[] = array_pop($items);
            $payable[] = array_pop($items);
            if (end($items) < end($payable)) {
                $discounted[] = array_pop($items);
            }
            if (end($items) < end($payable)) {
                $discounted[] = array_pop($items);
            }
        }
        while (count($items) > 0) {
            $payable[] = array_pop($items);
        }

        return response()->json([
            'discounted_items' => $discounted,
            'payable_items' => $payable
        ]);
    }
}
